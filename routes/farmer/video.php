<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Farmer\VideoController;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Middleware\VerifyToken;

Route::middleware([VerifyAppKey::class])->group(function () {
    Route::middleware([VerifyToken::class])->group(function () {
        Route::controller(VideoController::class)->group(function () {
            // Route::get('/farmer/getvideo', 'index');
            Route::post('/farmer/getvideo', 'get');
            Route::get('/farmer/search_product/{name}', 'searchVideobyname');
            Route::get('/farmer/getvideobycategory', 'getVideobyCategory');
            Route::get('/farmer/getvideobyid/{id}', 'getVideoById');
            Route::get('/farmer/getSubtype', 'getSubTypeVideo');
        });
    });
});
