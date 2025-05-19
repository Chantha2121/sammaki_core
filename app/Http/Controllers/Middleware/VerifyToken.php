<?php

namespace App\Http\Controllers\Middleware;

use Closure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class VerifyToken extends Controller
{
    //
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        
        if(!$authorization || !str_starts_with($authorization, 'Bearer ')){
            return response()->json(['message' => 'Unauthorized No Token Provided'], 401);
        }

        $token = substr($authorization, 7);

        $accessToken = PersonalAccessToken::findToken($token);

        // Check if token is valid
        if(!$accessToken){
            return response()->json(['message' => 'Unauthorized Invalid Token'], 401);
        }

        // Declare user
        $user = $accessToken->tokenable;

        if(!$user){
            return response()->json(['message' => 'Unauthorized User Not Found'], 401);
        }

        $request->merge(['person_id'=>$user->id]);

        return $next($request);

    }


}
