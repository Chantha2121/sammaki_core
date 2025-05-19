<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Farmer\YourProfileController;
use App\Http\Controllers\Middleware\VerifyToken;


Route::middleware([VerifyAppKey::class])->group(function(){
    Route::middleware([VerifyToken::class])->group(function(){
        Route::controller(YourProfileController::class)->group(function(){
            Route::get('/farmer/getyourProfile', 'get');
            Route::post('/farmer/uploadImage','upload_image');
            Route::put('/farmer/update_profile', 'update_profile');
            Route::post('/farmer/change_password', 'change_password');
        });
    });
});