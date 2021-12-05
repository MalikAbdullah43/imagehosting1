<?php
namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\mail;
use App\Mail\SignupMail;
use App\Jobs\SignupEmailJob;
use App\Jobs\LoginEmailJob;

class MailService{    
    
 /// If User Login Then This Function Call Response Send On User Email
 public static function login_mail($email)
 {
     $details = [
         'title' => 'Log in Confirmation Mail',
         'Message' => 'Your Are Log in At ' . now()
     ];
 
     dispatch(new LoginEmailJob($details));
     return true;
 
 }



   static public function mail($email)
    {
        $details = ['title'=>'Hello Malik',
                    'link' =>'http://127.0.0.1:8000/user/verification'.'/'.$email,
                    'link1' => 'http://127.0.0.1:8000/user/regenrate'.'/'.$email];
                    dispatch(new SignupEmailJob($details));
                    return true;     
    }
}