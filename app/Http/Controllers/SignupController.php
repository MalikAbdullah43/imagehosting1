<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use App\Service\MailService;

class SignupController extends Controller
{
    function signUp(SignupRequest $request)
    {
        try {
            //Using Model
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->age = $request->age;

            if (!empty($request->image)) {
                $result = $request->file('image')->store('apidoc');
                $user->image = $result;
            }
            $user->save();

            $id = $user["_id"];
            if (!empty($id)) {
                $response  = $this->SignUpMail($id, $request->email);

                if ($response === true)

                    return response()->json(["message" => "Your Account is Ready Kindly Verify Your Email", "status" => "201"], 201);
                else return response()->json(["message" => "User Not Registered", "status" => "500"], 500);
            } else {
                return response()->json(["message" => "User Not Registered", "status" => "500"], 500);
            }
        } catch (Exception $error) {
            return $error;
        };
    }
    
    public function SignUpMail($id, $email)
    {
        try {
            $mail = new MailService();
            $response   = $mail->mail($email);
            if ($response == true) {
                $time = now()->addMinutes(30)->__toString();
                $user = User::where(['_id' => $id])
                    ->update(['email_verified_at' => null, 'status' => 0, 'link_expiry' => $time]);
                return true;
            } else   return false;
        } catch (Exception $error) {
            return $error;
        };
    }
}
