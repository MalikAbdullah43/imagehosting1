<?php
namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\mail;
use App\Mail\SignupMail;
use App\Jobs\SignupEmailJob;
use App\Jobs\LoginEmailJob;
use App\Jobs\ForgetPasswordJob;
use App\Jobs\UpdatemailJob;

class MailService{    
    
 /// If User Login Then This Function Call Response Send On User Email
 public static function login_mail($email)
 {
    
     $details = [
         'title' => 'Log in Confirmation Mail',
         'Message' => 'Your Are Log in At ' .now()];
         
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

    public static function forgetmail($email, $otp)
    {
        $details = [
            'title' => 'Hello Dear User',
            'Message' => 'This is  Your Otp:' . $otp,
        ];
      
        $mailQueue  = dispatch(new ForgetPasswordJob($details));
    
    }

    public static function updatemail($email, $otp)
    {
        

        $details = [
            'title' => 'Hello Dear User',
            'Message' => "We received a request to change the email of your Malikabdullah43 account at ImgBB.

            To complete the process you must activate your email.
            
            Alternatively you can copy and paste the URL into your browser: https://imgbb.com/account/change-email-confirm/x3pmPv7VvVRbgT5f
            
            If you didn't intend this just ignore this message.
            
            --
            This email was sent from https://malikabdullah.com"
        ];
      
        $mailQueue  = dispatch(new UpdatemailJob($details));
    
    }

}
?>