<?php
namespace App\Service;

use App\Jobs\SignupEmailJob;
use App\Jobs\LoginEmailJob;
use App\Jobs\ForgetPasswordJob;
use App\Jobs\UpdatemailJob;
use App\Jobs\RegenrateLink;

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


  //Sign Up Function For Mail Sending Towards Email
    public static function mail($email)
    {
        $details = ['title'=>'Hello Malik',
                    'link' =>'http://' .$_SERVER['HTTP_HOST'].'/user/verification'.'/'.$email,
                    'link1' =>'http://'.$_SERVER['HTTP_HOST'].'/user/regenrate'.'/'.$email];
                    
                    dispatch(new SignupEmailJob($details));
                    return true;     
    }

    //Regenrate Verification mail Function For sending Toward Job
    public static function RegenrateMail($email)
    {
        $details = [
            'title' => 'This Social Application Verifacation',
            'link'  => 'http://'.$_SERVER['HTTP_HOST'].'/user/verification' . '/' . $email,
            'link1' => 'http://'.$_SERVER['HTTP_HOST'].'/user/regenrate' . '/' . $email
        ];
        //Mail Sending Facade
             dispatch(new RegenrateLink($details));
             return true;
    }


    //Forget Mail Function For sending Toward Job
    public static function forgetmail($email, $otp)
    {
        $details = [
            'title' => 'Hello Dear User',
            'Message' => 'This is  Your Otp:' . $otp,
        ];
      
        $mailQueue  = dispatch(new ForgetPasswordJob($details));
        return true;
    }
  //Update Email Mail Function For sending Toward Job
    public static function updatemail($email,$code)
    {
        
        $details = [
            'title' => 'If You Want To Change Email of Your App Then Click on this Link..',
            'link'  => 'http://'.$_SERVER['HTTP_HOST'].'/user/updatemail' . '/' . $email.'/'.$code,
        ];
      
        $mailQueue  = dispatch(new UpdatemailJob($details));
        return true;
    
    }

}
