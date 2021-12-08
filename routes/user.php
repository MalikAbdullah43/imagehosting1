<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;



Route::get('verification/{email}',[EmailVerifyController::class,"verify"]);                        //Link Verification Route
Route::get('regenrate/{email}',[EmailVerifyController::class,"regenrate_link"]);                   //Verirfy Link Re Create Route



Route::middleware(['CheckEmailVerification'])->group(function(){
    //User Routes
    Route::post('login',[LoginController::class,"logIn"]);   //Log in Route
    Route::post('forgetpassword',[PasswordController::class,"forgetPassword"]);          //Forget Route
    
});


Route::middleware(['UserVerification'])->group(function(){
    //User Routes
    Route::post('logout',[UserController::class,"logOut"]);    //Log Out Route
    Route::post('uedit',[UserController::class,"edit"]);
    Route::post('updatemail',[UserController::class,"UpdateEmail"]);
    //Password Reset Request Identify
    Route::post('checkotp',[PasswordController::class,"checkOtp"])->middleware('otp.check');          //Otp Check
    Route::post('resetpassword',[PasswordController::class,"passwordReset"]);          //Password Reset Route
});
