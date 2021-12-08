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

class UserController extends Controller
{

   //For Updation User Data
   public function edit(UpdateProfileRequest $request)
   { ///
      $updation = [];
      if (!empty($request->file('image'))) {          //If Image Update request Recieve
         $result = $request->file('image')->store('apidoc');
         $updation['image'] = $result;
      }
      foreach ($request->all() as $key => $value) {          //Take Changes in Array
         if (in_array($key, ['name', 'email', 'gender'])) {
            $updation[$key] = $value;
         }
      }
      if (!empty($request->password))   //if Password change rewuest recieve
         $updation['password'] = Hash::make($request->password);

      if (!empty($updation)) {   //if any update request recieve
         $updation['updated_at'] =  date(now()->addMinutes(30));   //increase token time
         $jwt = $request->bearerToken();  //catch jwt token from bearer
         $user = USer::where('Auth_key', $jwt)->update($updation);  //Update in database 
         if ($user > 0) {
            return response()->success(200);
         }
      } else
         return response()->error(303);
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

  public function UpdateEmail(UpdateEmailRequest $request){
    

      



  }


}
?>