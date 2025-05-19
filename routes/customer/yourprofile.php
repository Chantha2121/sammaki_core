<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Customer\YourProfileController;
use App\Http\Controllers\Middleware\VerifyToken;


Route::middleware([VerifyAppKey::class])->group(function(){
    Route::middleware([VerifyToken::class])->group(function(){
        Route::controller(YourProfileController::class)->group(function(){
            Route::get('/customer/getyourProfile', 'get');
            Route::post('/customer/uploadImage','upload_image');
            Route::put('/customer/update_profile', 'update_profile');
            Route::post('/customer/change_password', 'change_password');
        });
    });
});