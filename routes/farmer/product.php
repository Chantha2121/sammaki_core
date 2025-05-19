<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Farmer\ProductController;
use App\Http\Controllers\Middleware\VerifyToken;


Route::middleware([VerifyAppKey::class])->group(function(){
    Route::middleware([VerifyToken::class])->group(function(){
        Route::get('/farmer/getOurProductAll', [ProductController::class, 'index']);
    });
});