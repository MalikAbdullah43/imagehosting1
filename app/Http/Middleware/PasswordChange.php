<?php

namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class PasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        $jwt = $request->bearerToken();
   
        if (!empty($jwt)){
            $data = User::where('Auth_key_P', $jwt)->where('updated_at', '>=', date(now()))->first();

          if (!isset($data->_id))
                return response()->error(404);
          else
                return $next($request->merge(["user_data" => $data]));
        } 
        else return response()->error(401);
    }
}
