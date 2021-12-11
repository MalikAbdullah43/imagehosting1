<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Service\ImageDecode;
use Exception;

class ImageController extends Controller
{
    //Public Images
    public function uploadImage(ImageRequest $request)
    {
        try {
            $data = ImageDecode::imageDecode($request->image);  //Array Coming from 
            $data['original_name']=$request->original_name;
            if ($request->accessor === "private"){
                $data['accessor']  = $request->accessor;
                $data['emails']    = explode(',', $request->email);
            }
            else if($request->accessor === "public")
                 $data['accessor']  = $request->accessor;
            else 
                 $data['accessor']  = "hidden";

            
            $data['user_id']       = $request->user_data->_id;
            //Insatance Create Model Image
            $arr = new Image($data);
            $arr->save();
            if (!empty($arr->_id))
                return response()->json($arr, 201);
            else response()->error();
        } catch (Exception $error) {
            return $error;
        };
    }

    //Remove Picture
    public function removeImage(Request $request)
    {
        try {
            $image = Image::where(['user_id' => $request->user_data->id, 'key' => +$request->id])->first();
         
            if (!empty($image)) {
                $image->delete();
                return response()->success(200);
            } else
                return response()->error(404);
        } catch (Exception $error) {
            return $error;
        };
    }


    //Here We Delete Selected Images
    //Extra Work Do in Free Time
    // public function deleteSelectedImage(Request $request)
    // {
    //     $image = Image::where('user_id', $request->user_data->id)->get();
    //     if ($image->count() > 0) {
    //         $data = [];
    //         foreach ($request->all() as $key => $value) {
    //             $data[$key] = $value->_id;
    //             $images = Image::find($data[$key]);
    //             $images->delete();
    //         }
    //         return response()->success(200);
    //     } else
    //         return response()->error(404);
    // }


    //Here We Delete All Images
    public function deleteAllImage(Request $request)
    {

        try {
            $image = Image::where('user_id', $request->user_data->id)->get();
            if ($image->count() > 0) {
                $data = [];
                foreach ($image as $key => $value) {
                    $data[$key] = $value->_id;
                    $images = Image::find($data[$key]);
                    $images->delete();
                }
                return response()->success(200);
            } else
                return response()->error(404);
        } catch (Exception $error) {
            return $error;
        };
    }


    //List All Images in This Function

    public function listAllPhotos(Request $request)
    {
        try {
            $images = Image::where('user_id', $request->user_data->key)->get();
            if ($images->count() > 0)
                return response()->json($images);
            else return response()->error(404);
        } catch (Exception $error) {
            return $error;
        };
    }

    //Get Image Through Image URL
    public function imageUrl(Request $request){
        try{
            $path = storage_path("app" . '/' .$request->image_data->key.'.'.$request->image_data->extension);
         
            if (file_exists($path))
                return response()->download($path, null);
            else
                return response()->json(["error" => "error downloading file"], 400);
        } catch (exception $error) {
            return $error;
        };
    }


    //Searching image With Filters
    public function searchImage(Request $request){

        $image = new Image();
        //Filter query 
        $updation = [];
        foreach ($request->all() as $key => $value)          //Take Changes in Array
            if (in_array($key, ['originalname', 'date', 'time', 'extension', 'accessor']))
                $updation[$key] = $value;
        $data = $image->where($updation)->get();
        if ($data != null)
            return response()->json($data);
        else
            return response(["message" => "data not found"], 404);

    }
}
