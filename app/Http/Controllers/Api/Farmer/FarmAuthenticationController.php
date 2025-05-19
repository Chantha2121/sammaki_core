<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Address;
use App\Models\TypeFarm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FarmAuthenticationController extends Controller
{
    //
    public function login(Request $request){
        try{
            $validated = $request->validate([
                'phone_number' => 'required|string',
                'password' => 'required|string'
            ]);

            $farmer = Farmer::where('phone_number', $validated['phone_number'])->firstOrFail();

            // check password
            if(!$farmer || !Hash::check($validated['password'], $farmer->password)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Generate token
            $token = $farmer->createToken('farmer_token')->plainTextToken;

            // return response
            return response()->json([
                'message'=> 'Login successful',
                'farmer'=> $farmer,
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'error' => $e->getMessage()
            ], 400);
        }
        
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|unique:farmers',
                'type_farm' => 'required|string',
                'address' => 'required|string',
                'password' => 'required|string|min:8',
            ]);
            
            // Get Address and TypeFarm with error handling
            $address = Address::where('description_kh', $validated['address'])->firstOrFail();
            $typeFarm = TypeFarm::where('description_kh', $validated['type_farm'])->firstOrFail();

            // Create farmer with hashed password
            $farmer = Farmer::create([
                'name' => $validated['name'],
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make($validated['password']), // Use Hash facade
                'address_id' => $address->id,
                'type_farmer_id' => $typeFarm->id
            ]);

            // Generate token
            $token = $farmer->createToken('farmer_token')->plainTextToken;

            // Return response without password
            return response()->json([
                'status' => 'success',
                'message' => 'Farmer created successfully',
                'data' => [
                    'farmer' => $farmer->makeHidden('password'), // Hide password in response
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address or Farm Type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function changepassword(Request $request){
        $validated = $request->validate([
            'current_password'=> 'required|string',
            'new_password'=> 'required|string'
        ]);

        $farmer = new Farmer();

        if(!Hash::check($validated['current_password'], $farmer->password)){
            return response()->json([
                'message' => 'password is incorrect'
            ]);
        }

        $farmer->password = Hash::make($validated['new_password']);
        $farmer->save();

        return response()->json([
            "message" => "changed password is successfully"
        ]);
    }
}
