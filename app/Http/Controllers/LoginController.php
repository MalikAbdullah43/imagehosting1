<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Service\TokenService;
use App\Service\MailService;

class LoginController extends Controller
{
    //Log In Function Call
    public function logIn(LoginRequest $request)
    {
        $Auth_key = TokenService::encode();     //Jwt Token Get From Token Service
        $time = now()->addMinutes(30);
        $user = User::where('_id', $request->user->_id)->update(['updated_at' => date($time), 'Auth_key' => $Auth_key]);
        if ($user > 0) {
            $mail = MailService::login_mail($request->email);
            return response()->json(["message" => "Successfully Login", "Status" => 200, 'Auth_key' => $Auth_key,], 200);
        }else return  response()->json(["message" => "Something Wrong", "Status" => 500], 500);
    }
}
