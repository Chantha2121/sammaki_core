<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Middleware\VerifyAppKey;
use App\Http\Controllers\Api\Farmer\FarmAuthenticationController;

Route::middleware([VerifyAppKey::class])->group(function(){
    Route::post('/farmer/login',[FarmAuthenticationController::class,'login']);
    Route::post('/farmer/register',[FarmAuthenticationController::class,'register']);
    Route::post('/farmer/changepassword',[FarmAuthenticationController::class,'changepassword']);
});
