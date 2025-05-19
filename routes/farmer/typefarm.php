<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Farmer\TypeFarmController;
use App\Http\Controllers\Middleware\VerifyAppKey;

Route::middleware([VerifyAppKey::class])->group(function(){
    Route::get('/farmer/gettypefarm',[TypeFarmController::class,'index']);
});
