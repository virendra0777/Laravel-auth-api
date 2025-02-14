<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserContestController;
use App\Http\Controllers\MyContestController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\OtherController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\CronController;
use App\Http\Controllers\admin\ContestController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//user routes
Route::group(['prefix'=>'user'],function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class,'register']);
   Route::middleware('jwt.user')->group(function(){
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
        Route::get('resend-otp/{type}', [AuthController::class, 'resendOtp']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('get-profile', [AuthController::class, 'getProfile']);
        Route::post('support', [AuthController::class, 'support']);
    });
});

// admin routes
Route::group(['prefix'=>'admin'],function (){
    Route::post('login', [AdminController::class, 'login']);
    Route::post('refresh', [AdminController::class, 'refresh']);
    Route::middleware('jwt.admin')->group(function(){
        Route::post('change-password', [AdminController::class, 'changePassword']);
    });
});

