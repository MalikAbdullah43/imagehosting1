<?php
namespace App\Service;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImageDecode{    
    
 /// If User Login Then This Function Call Response Send On User Email

    public static function imageDecode($image){
        //Decode Base 64
        $base64_string =  $image;  
        $extension = explode('/', explode(':', substr($base64_string, 0, strpos($base64_string, ';')))[1])[1]; // .jpg .png .pdf
        $replace   = substr($base64_string, 0, strpos($base64_string, ',')+1);
        $image     = str_replace($replace, '', $base64_string);
        $image     = str_replace(' ', '+', $image);
        return       ImageDecode::imageInfo($image,$extension);
        //End Decode Base 64
    }

     public static function imageInfo($image,$extension){

        //Image Information
        $fileName  = time().'.'.$extension;
        $key = rand(111,999)*time();

        $image_url     = 'http://' . $_SERVER['HTTP_HOST'] . "/image/storage/" . $key;
        $hashName  = hash::make($fileName);
        $date      = date("m/d/Y");
        $time      = date("h:i A");
        $imageArr  = array('filename'=>$fileName,'extension'=>$extension,'hashname'=>$hashName,'date'=>$date,'time'=>$time,'image_url'=>$image_url,'key'=>$key);
        Storage::disk('local')->put( $key.'.'.$extension,base64_decode($image));
   
        //End Image Information
        return $imageArr;

     }

        


    






}
