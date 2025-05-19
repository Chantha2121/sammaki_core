<?php
use Illuminate\Https\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Customer\CustomerAuthenticationController;

Route::middleware([VerifyAppKey::class])->group(function(){
    Route::post('/customer/login',[CustomerAuthenticationController::class,'login']);
    Route::post('/customer/register',[CustomerAuthenticationController::class,'register']);
});
