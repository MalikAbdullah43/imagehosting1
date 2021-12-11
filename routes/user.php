<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Method: *');


Route::get('verification/{email}',[EmailVerifyController::class,"verify"]);                        //Link Verification Route
Route::get('regenrate/{email}',[EmailVerifyController::class,"regenrate_link"]);                   //Verirfy Link Re Create Route
Route::post('forgetpassword',[PasswordController::class,"forgetPassword"]);
Route::post('updatemail/{email}/{code}',[UserController::class,"UpdateEmail"]);

Route::middleware(['change'])->group(function(){
    
    Route::post('checkotp',[PasswordController::class,"checkOtp"])->middleware('otp.check');          //Otp Check
    Route::post('resetpassword',[PasswordController::class,"passwordReset"]);          //Password Reset Route
    
});

Route::middleware(['check.email.verification'])->group(function(){
    //User Routes
    Route::post('login',[LoginController::class,"logIn"]);   //Log in Route
    
});


Route::middleware(['user.verification'])->group(function(){
    //User Routes
    Route::post('logout',[UserController::class,"logOut"]);    //Log Out Route
    Route::post('uedit',[UserController::class,"edit"]);
    Route::put('updatemail',[UserController::class,"UpdateEmailReq"])->middleware('checkmail');
    //Password Reset Request Identify
   
});
