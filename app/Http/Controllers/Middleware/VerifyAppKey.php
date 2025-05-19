<?php

namespace App\Http\Controllers\Middleware;

use Closure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyAppKey extends Controller
{
    //
    public function handle(Request $request, Closure $next){
        $apiKey = $request->header('APP_KEY');

        if(!$apiKey || $apiKey != env('APP_KEY')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
