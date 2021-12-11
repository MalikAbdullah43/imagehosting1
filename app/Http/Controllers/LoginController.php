<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
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
            return new LoginResource(["message" => "true", "Status" => 200,"Auth_key"=>$Auth_key,"data"=>$request->user], 200);
            
        }else return  new LoginResource(["message" => "false", "Status" => 500], 500);
    }
}
