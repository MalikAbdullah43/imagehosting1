<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    //Public Images
    public function uploadImage(ImageRequest $request)
    {
        //Insatance Create Model Image
        $data = new Image();
        $image = (array)$request->image;
        $data->image_name    = $_SERVER['HTTP_HOST']."/storage/".$request->file('image')->store('images');
        $original_name       = $image["\x00Symfony\Component\HttpFoundation\File\UploadedFile\x00originalName"];
        $data->original_name = $original_name;
        $extension     = explode('.', $original_name);
        $data->extension     = $extension[1];
        $data->date          = date("m/d/Y");
        $data->time          = date("h:i A");
        $data->accessor      = $request->accessor;
        $data->user_id       = $request->user_data->_id;
        $data->save();
        return response()->json($data,201);
    }

    //Remove Picture
    public function removeImage(Request $request){
                  $image = Image::where(['user_id'=>$request->user_data->id,'_id'=>$request->id])->first();
                  if(!empty($image)){
                  $image -> delete();
                  return response()->success(200);
                  }
                  else
                  return "Not Delete";
    }

    //








    
    public function imageUrl(Request $request){
            
   // $headers = ["Cache-Control" => "no-store, no-cache, must-revalidate, max-age=0"]
     $path = storage_path("app/images" . '/' . $request->key);
     var_dump($path);
     die();
     if (file_exists($path))
            return response()->download($path, null);
     else
            return response()->json(["error" => "error downloading file"], 400);
    }
}
