<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\CheckOtpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\mail;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\User;
use App\Service\MailService;
use App\Service\TokenService;

class PasswordController extends Controller
{
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        //Token
        $user = User::where(['email'=> $request->email, 'status' => "1"])
           ->where('email_verified_at','!=','null')   //Checking if user Email Verify or Not
            ->first();
        if (!empty($user->_id)) {
            $otp = rand(111111, 999999);
            $Auth_key = TokenService::encode();     //JWT Updation And Printing Message of Log in
            $time = now()->addMinutes(30);
            $user = User::where('email', $request->email)
                ->update(['Auth_key' => $Auth_key, "otp" => $otp, 'updated_at' => date($time)]);
            //Token Validity Increase if All Activity Perfoam And Message Show
            MailService::forgetmail($request->email, $otp);
            return response(
                [
                    "message" => "Otp Send On Email", "status" => "200", "Auth_key1" => $Auth_key
                ],
                200
            );
        } else return response()->error(404);
    }

    //Reset Password

    public function checkOtp(CheckOtpRequest $request)
    {
        $jwt = $request->bearerToken();
        $time = now()->addMinutes(30);
        $Auth_key = TokenService::encode();     //JWT Updation And Printing Message of Log in
        $update = User::where('_id', $request->user_data->_id)->update([ 'Auth_key' => $Auth_key,'updated_at'=>date($time)]);
        if($update>0)
        return response()->json(["message" => "Otp Send On Email", "status" => "200", "Auth_key2" => $Auth_key], 200  );
        else    return response()->error(404);    
    }


    public function passwordReset(ResetPasswordRequest $request)
    {
            $update = User::where('_id', $request->user_data->_id)->update(['password' => Hash::make($request->new_password), 'Auth_key' => '','otp'=>'']);
            if ($update > 0) {
                return response()->success(200);
            } else {
                return response()->error(404);
            }
    } 
    
}
