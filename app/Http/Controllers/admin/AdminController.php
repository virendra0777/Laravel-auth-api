<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\User;
use JWTFactory;
use JWTAuth;
use Tymon\JWTAuth\Token;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->email == '' || !preg_match("/^[^@]{1,64}@[^@]{1,255}$/",$request->email)){
            return $this->validationErrorMessage('Please Enter valid Email');
        } else if($request->password == '' || !preg_match("/^(?=.*?[a-z])(?=(.*[\W]){1,})(?!.*\s).{8,}$/",$request->password)){
            return $this->validationErrorMessage('Please Enter valid Password');
        } else {
            $user = User::AdminRole()->where('email', $request->email)->first();
            if($user && Hash::check($request->password,$user->password)){
                $user['token'] = JWTAuth::fromUser($user);
                return $this->successDataMessage('User login successfully',$user);
            } else {
                return $this->validationErrorMessage('You have entered an invalid email or password');
            }
        }
    }

    public function refresh(Request $request){
        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        $user = JWTAuth::setToken($refreshed)->toUser();
        // $user = Auth::user();
        $user['token'] = Auth::refresh();
        return $this->successDataMessage('success',$user);
    }

    public function changePassword(Request $request){
        $user = User::getById($request->admin->_id)->first();
        if($request->password == '' || !preg_match("/^(?=.*?[a-z])(?=(.*[\W]){1,})(?!.*\s).{8,}$/",$request->password)){
            return $this->validationErrorMessage('Please Enter valid Password');
        }else{
            if($user && Hash::check($request->old_password,$user->password)){
                $update = User::where("_id", $user->_id)->update(["password" => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s')]);
                if($update){
                    return $this->successMessage('Password change successfully');
                }else{
                    return $this->errorMessage('Error');
                }
            }else{
                return $this->validationErrorMessage('Old password not matched');
            }
        }
    }
}
