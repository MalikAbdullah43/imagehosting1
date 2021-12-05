<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\LoginController;



Route::get('verification/{email}',[EmailVerifyController::class,"verify"]);                        //Link Verification Route
Route::get('regenrate/{email}',[EmailVerifyController::class,"regenrate_link"]);                   //Verirfy Link Re Create Route
Route::post('login',[LoginController::class,"logIn"])->middleware('CheckEmailVerification');   
?>