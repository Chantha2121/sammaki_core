<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Farmer\FarmerProductController;
use App\Http\Controllers\Middleware\VerifyToken;


Route::middleware([VerifyAppKey::class])->group(function(){
    Route::middleware([VerifyToken::class])->group(function(){
        Route::controller(FarmerProductController::class)->group(function(){
            Route::post('/farmer/getAllProduct', 'get');
            Route::post('/farmer/addproduct',  'store');
            Route::get('/farmer/getProduct',  'get_productType');
            Route::get('/farmer/yourproduct', 'get_product_by_farmer');
        });
    });
});