<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Farmer\AddressController;
use App\Http\Controllers\Middleware\VerifyAppKey;

Route::middleware([VerifyAppKey::class])->group(function(){
    Route::get('/farmer/getaddress',[AddressController::class,'index']);
});