<?php


use Illuminate\Https\Request;
use App\Http\Controllers\Api\Customer\OurproductController;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Middleware\VerifyToken;

Route::middleware([VerifyAppKey::class])->group(function () {
    Route::middleware([VerifyToken::class])->group(function () {
        Route::controller(OurproductController::class)->group(function () {
            Route::post('/customer/getourproduct', 'get');
            Route::get('/customer/getproductType', 'get_productType');
        });
    });
});