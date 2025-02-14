<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Supports;
use JWTFactory;
use JWTAuth;
use App\Events\LoginHistory;
use DB;

class AuthController extends Controller
{

    public function login(Request $request){
        if($request->mobile == '' || !preg_match("/^\+(?:[0-9] ?){10,14}[0-9]$/",$request->mobile)){
            return $this->validationErrorMessage('Please Enter valid mobile');
        }else{
            $user = User::UserRole()->where('mobile',$request->mobile)->first();
            if($user){
                if($user->status == 1){
                    $update = User::where("_id", $user->_id)->update(["mobile_otp" => 1234,'updated_at' => date('Y-m-d H:i:s')]);
                    $data['token'] = JWTAuth::fromUser($user);
                    event(new LoginHistory(['userId' => $user->_id, 'ip' => request()->ip() ,'screen_name' => 'Login', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]));
                    return $this->successDataMessage('User login successfully',$data);
                } else {
                    return $this->validationErrorMessage('Your Account Is Inactive, Please Contact Administrator');
                }
            }else{
                return $this->validationErrorMessage('You have entered an invalid mobile');
            }
        }
    }

    public function register(Request $request){
        if($request->userName == ''){
            return $this->validationErrorMessage('Please Enter user name');
        }else if($request->dob == ''){
            return $this->validationErrorMessage('Please Enter date of birth');
        } else if($request->mobile == '' || !preg_match("/^\+(?:[0-9] ?){10,14}[0-9]$/", $request->mobile)) {
            return $this->validationErrorMessage('Please Enter valid mobile number');
        } else{
            $isexist = User::where('username',$request->userName)
                ->orwhere('mobile',$request->mobile)
                ->orwhere('referal_code',$request->referalCode)
                ->first();
            if($isexist && $isexist->username == $request->userName){
                return $this->validationErrorMessage('User name already exist!');
            } else if($isexist && $isexist->mobile == $request->mobile){
                return $this->validationErrorMessage('Mobile number already exist!');
            } else if(!$isexist && $request->referalCode){
                return $this->validationErrorMessage('Invalid Referal code!');
            } else {
                $mobileOtp = 1234;
                $emailOtp = 0;
                $user = User::create([
                    'firstname' => $request->firstName,
                    'lastname' => $request->lastName,
                    'email' => '',
                    'password' => '',
                    'username' => $request->userName,
                    'dob' => date('Y-m-d',strtotime($request->dob)),
                    'referal_code' => Str::random(6).substr( str_shuffle( $request->userName ), 0, 6 ),
                    'referal_user' => $request->referalCode ?  $request->referalCode : '',
                    'mobile' => $request->mobile,
                    'email_otp' => $emailOtp,
                    'mobile_otp' => $mobileOtp,
                    'profilepic' => '',
                    'appId' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                if($user){
                    $data['token'] = JWTAuth::fromUser($user);
                    return $this->successDataMessage('User created successfully',$data);
                } else {
                    return $this->validationErrorMessage('Error');
                }
            }
        }
    }

    public function verifyOtp(Request $request){
        $user = User::where('_id', $request->user->_id)->first();
        if($request->type == 'email' && ($request->otp == '' || $user->email_otp != $request->otp)){
            return $this->validationErrorMessage('Please Enter valid Email Otp');
        } else if($request->type == 'mobile' && ($request->otp == '' || $user->mobile_otp != $request->otp)){ 
            return $this->validationErrorMessage('Please Enter valid mobile Otp');
        }else{
            $update = User::where("_id", $request->user->_id)
                ->update(["email_otp" => 0,'status' => '1',"mobile_otp" => 0,'mobile_verified' => '1','email_verified' => ($request->type == 'email' ? '1' : '0') ,'updated_at' => date('Y-m-d H:i:s')]);
            if($update){
                unset($user->appId);
                unset($user->role);
                unset($user->updated_at);
                unset($user->email_otp);
                unset($user->mobile_otp);
                return $this->successDataMessage('Otp verify successfully',$user);
            }else{
                return $this->errorMessage('Error');
            }
        }
    }

    public function resendOtp(Request $request){
        $emailOtp = $request->route('type') == 'email' ? 1234 : 0;
        $mobileOtp = $request->route('type') == 'mobile' ? 1234 : 0;
        $update = User::where("_id", $request->user->_id)
            ->update(["email_otp" => $emailOtp, "mobile_otp" => $mobileOtp ,'updated_at' => date('Y-m-d H:i:s')]);
        if($update){
            return $this->successMessage('Otp resend successfully');
        }else{
            return $this->errorMessage('Error');
        }
    }

    public function getProfile(Request $request){
        return $this->successDataMessage('Profile get successfully',$request->user);
    }

    public function logout(){
        Auth::logout();
        return $this->successMessage('Successfully logged out');
    }

    public function refresh(Request $request){
        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        $user = JWTAuth::setToken($refreshed)->toUser();
        $user['token'] = Auth::refresh();
        return $this->successDataMessage('success',$user);
    }

    public function support(Request $request){
        $support = Supports::create([
            'userId' => $request->user->_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'isreply' => '0',
            'status' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if($support) {
            return $this->successMessage('Thank you for query. Support will contact you soon.');
        }else{
            return $this->errorMessage('Error');
        }
    }
}
