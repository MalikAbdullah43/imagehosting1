<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CheckEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $password  = $request->password;  //Hashing Purpose

        $pass = User::where('email', $request->email)->first();
    
        if (Hash::check($request->password, $pass->password))  //If Password Match
        {
            $user = User::where(['email'=> $request->email,'status'=>"1"])
                ->where('email_verified_at','!=','null')   //Checking if user Email Verify or Not
                ->first();
        
            if (!empty($user))
                return $next($request->merge(["user" => $user]));
            else
                return response()->error(401);
        } else  return response()->error(404); //If User Input Not Match Then Through This Message

    }
}
