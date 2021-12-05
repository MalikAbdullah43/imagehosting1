<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SignupController;



Route::get('verification/{email}',[EmailVerifyController::class,"verify"]);                        //Link Verification Route
Route::get('regenrate/{email}',[EmailVerifyController::class,"regenrate_link"]);                   //Verirfy Link Re Create Route

?>