<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Image;
use Exception;
use App\Models\User;

class CheckAccess
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
        try {

            $image = Image::where(['key' => +$request->key, 'accessor' => 'private'])->first();

            if (!empty($image)) {
                $jwt = $request->bearerToken();
                
                if (!empty($jwt)) {
                    $data = User::where(['Auth_key' => $jwt])->where('updated_at', '>=', date(now()))->first();

                    if (!isset($data->_id)) {
                        return response()->error(401);
                    } else {
                        $access = Image::where(['emails' => $data->email])->first();
                        dd($access);
                        return $next($request->merge(["user_data" => $data, "image_data" => $image]));
                    }
                }
            } else {
                $image = Image::where(['key' => +$request->key, 'accessor' => 'hidden'])->first();

                if (!empty($image)) {
                    $jwt = $request->bearerToken();
                    if (!empty($jwt)) {
                        $data = User::where('Auth_key', $jwt)->where('updated_at', '>=', date(now()))->first();

                        if (!isset($data->_id)) {
                            return response()->error(401);
                        } else {

                            return $next($request->merge(["user_data" => $data, "image_data" => $image]));
                        }
                    }
                }
            }
            $image = Image::where(['key' => +$request->key, 'accessor' => 'public'])->first();

            if (!empty($image))
                return $next($request->merge(["image_data" => $image]));
            else return response()->error(404);
        } catch (Exception $error) {
            return $error;
        };
    }
}
