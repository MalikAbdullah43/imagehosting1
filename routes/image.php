<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;


Route::any('storage/images/{key}', [ImageController::class, 'imageUrl'])->middleware('accessor');

Route::middleware(['UserVerification'])->group(function () {
    //Image Routes
    Route::post('imageupload', [ImageController::class, 'uploadImage']);
    Route::get('imagedelete/{id}', [ImageController::class, 'removeImage']);
});


?>