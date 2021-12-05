<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
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
            $user->password =  Hash::make($request->password);
            $user->age = $request->age;

            if (!empty($request->image)) {
                $result = $request->file('image')->store('apidoc');
                $user->image = $result;
            }
            $response  = $this->signUpMail($request->email);
            
            if ($response === true) {         //if Mail Send then Save Data in Database and Print message
                $user->save();  //Save Data in Database
                $id = $user["_id"];
                $response = $this->afterEmailSend($id);
                if ($response === true)
                    return response()->json(["message" => "Your Account is Ready Kindly Verify Your Email", "status" => "201"], 201);
                else
                    return response()->json(["message" => "User Not Registered", "status" => "500"], 500);
            } else return response()->json(["message" => "User Not Registered", "status" => "500"], 500);
        } catch (Exception $error) {
            return $error;
        };
    }
  //Send Mail to User
    public function signUpMail($email)
    {
        try {
            $mail = new MailService();
            $response   = $mail->mail($email);
            if ($response == true)
                return true;
            else
                return false;
        } catch (Exception $error) {
            return $error;
        };
    }
    //If Mail Send Then Add Data in Database
    public function afterEmailSend($id)
    {
        try {
            $time = now()->addMinutes(30)->__toString();
            $user = User::where(['_id' => $id])
                ->update(['email_verified_at' => null, 'status' => 0, 'link_expiry' => $time]);
            return true;
        } catch (Exception $error) {
            return $error;
        };
    }
}
