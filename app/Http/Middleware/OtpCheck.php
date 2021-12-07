<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class OtpCheck
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
        $jwt = $request->bearerToken();
        
        if(!empty($jwt)){
        $data = User::where(['Auth_key'=>$jwt,'otp'=> +$request->otp])
                    ->where('updated_at','>=',date(now()))
                    ->first();

        if (!isset($data->_id)){
            return response()->error(401);
        }
        else{
        return $next($request);}
        }
        else{
            return response()->error(401);
        }
    }
}
