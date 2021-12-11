<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Service\UsersCollectionService;
use App\Models\User;

class SignupEmail
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
        app('App\Http\Requests\SignupRequest');
        $user = User::where(["email"=>$request->email])->first();
        if(!empty($user["_id"]))
        return response()->json(['message'=>'email already exist','status'=>'403'],403);
        
        return $next($request);
    }
}
