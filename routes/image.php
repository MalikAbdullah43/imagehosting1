<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Method: *');





Route::get('storage/{key}', [ImageController::class, 'imageUrl'])->middleware('accessor');

Route::middleware(['user.verification'])->group(function () {
    //Image Routes
    Route::post('imageupload', [ImageController::class, 'uploadImage']);
    Route::get('imagedelete/{id}', [ImageController::class, 'removeImage']);
    Route::get('allimage', [ImageController::class, 'listAllPhotos']);
    Route::get('allimagedelete', [ImageController::class, 'deleteAllImage']);
    Route::get('selectedimagedelete', [ImageController::class, 'deleteSelectedImage']);
    Route::post('imagesearch', [ImageController::class, 'searchImage']);
    
});


?>