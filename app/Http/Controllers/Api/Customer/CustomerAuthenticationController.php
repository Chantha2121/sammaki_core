<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerAuthenticationController extends Controller
{
    

    // Register function
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'identifier' => 'required|string',
            'password' => 'required|string'
        ]);

        $hasEmail = filter_var($validated['identifier'], FILTER_VALIDATE_EMAIL);
        $hasPhone = preg_match("/^[0-9]*$/", $validated['identifier']);

        if($hasEmail && $hasPhone){
            return response()->json([
                'error' => 'only one email or phone number to allowed'
            ],422);
        }

        if(!$hasEmail && !$hasPhone){
            return response()->json([
                'error' => 'email or phone number is not valid'
            ],422);
        }

        if($hasEmail && Customer::where('email', $validated['identifier'])->exists()){
            return response()->json([
                'error' => 'email already exists'
            ],422);
        }

        if($hasPhone && Customer::where('phone_number', $validated['identifier'])->exists()){
            return response()->json([
                'error' => 'phone number already exists'
            ],422);
        }

        $customer = new Customer();
        $customer->name = $validated['name'];
        if($hasEmail){
            $customer->email = $validated['identifier'];
        }else{
            $customer->phone_number = $validated['identifier'];
        }
        $customer->password = bcrypt($validated['password']);
        $customer->save();

        $user = Customer::where('email', $validated['identifier'])->orWhere('phone_number', $validated['identifier'])->first();

        // Generate token
        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'message' => 'customer registered successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
        
    }

    // Login function
    public function login(Request $request){
        $validated = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string'
        ]);

        $hasEmail = filter_var($validated['identifier'], FILTER_VALIDATE_EMAIL);
        $hasPhone = preg_match("/^[0-9]*$/", $validated['identifier']);

        $user = Customer::where('email', $validated['identifier'])->orWhere('phone_number', $validated['identifier'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json([
                'error' => 'email or phone number or password is not valid'
            ],422);
        }

        // Generate token
        $token = $user->createToken('customer_token')->plainTextToken;

        // Return response
        return response()->json([
            'message' => 'customer logged in successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);

        
    }

}
