<?php

namespace App\Http\Controllers;

use App\Service\MailService;
use App\Service\UsersCollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\mail;
use App\Mail\SignupMail;
use App\Models\User;


class EmailVerifyController extends Controller
{
    public function verify($email)
    {

        $user = new User();
        $nosql = $user->where('email', $email)->where('email_verified_at', NULL)
            ->update(['email_verified_at' => now()->__toString(), 'status' => '1']);
        if ($nosql>0) 
            return "Successfully Verify";
         else 
            return "Already Verified Or Link Expire";
        
    }

    public function regenrate_link($email)
    {
        $user = new User();

        $details = [
            'title' => 'This Social Application Verifacation',
            'link'  => 'http://127.0.0.1:8000/user/verification' . '/' . $email,
            'link1' => 'http://127.0.0.1:8000/user/regenrate' . '/' . $email
        ];
        //Mail Sending Facade
        Mail::to('malikabdullah4300@gmail.com')->send(new SignupMail($details));
        //MongoDB Query
        $time = now()->addMinutes(10)->__toString();  //link_expiry Extend 
        $nosql = $user->where(
            ['email' => $email, 'status' => 0]
        )->update(['$set' => ['link_expiry' => $time]]);

        //check if User Link is Valid regenerate link
        if ($nosql > 0)
            return "Email Regenrate Successfully";
        else
            return "Link Already Verify";
    }
}
