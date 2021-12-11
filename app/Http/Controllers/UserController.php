<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Service\ImageDecode;
use App\Service\MailService;
use Exception;

class UserController extends Controller
{

   //For Updation User Data
   public function edit(UpdateProfileRequest $request)
   { ///
      try{
      $updation = [];
      if (!empty($request->file('image'))) {          //If Image Update request Recieve
         $fileName = ImageDecode::imageDecode($request->profilePicture);
         $updation['image'] = $fileName['filename'];
      }
      foreach ($request->all() as $key => $value) {          //Take Changes in Array
         if (in_array($key, ['name', 'email', 'age'])) {
            $updation[$key] = $value;
         }
      }
      if (!empty($request->password))   //if Password change request recieve
         $updation['password'] = Hash::make($request->password);

      if (!empty($updation)) {   //if any update request recieve
         $updation['updated_at'] =  date(now()->addMinutes(30));   //increase token time
         $jwt = $request->bearerToken();  //catch jwt token from bearer
         $user = User::where('Auth_key', $jwt)->update($updation);  //Update in database 
         if ($user > 0) {
            return response()->success(200);
         }
      } else
         return response()->error(204);
   }catch (Exception $error) {
      return $error;
  };

   }


   public function logOut(Request $request)
   {
      $jwt = $request->bearerToken();
      $sql = User::where('Auth_key', $jwt)->update(['Auth_key' => '']);
      if ($sql > 0)
         return response()->success(200);
      else
         return response()->error(205);
   }



  public function UpdateEmailReq(UpdateEmailRequest $request){
   dd("error");
      try {
         $code = rand(111,999)*time();
         $res  = User::where(['_id'=>$request->user_id->_id])->update(['code'=>$code]);
          $response   = MailService::mail($request->email,$code);
          if ($response == true){
              return true;
            }
          else
              return false;
      } catch (Exception $error) {
          return $error;
      };
  }

  public function UpdateEmail(UpdateEmailRequest $request){
      
   try {
      $code = rand(111,999)*time();
      $res  = User::where(['code'=>$request->code])->update(['email'=>$request->email]);
      } catch (Exception $error) {
       return $error;
   };
}

      



  }



?>