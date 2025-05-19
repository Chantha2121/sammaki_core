<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;

class YourProfileController extends Controller
{
    public function get(Request $request){
        $farmer_id = $request->person_id;

        $data = Farmer::where('id', $farmer_id)->first();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function upload_image(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $farmer_id = $request->person_id;
            
            // Get the farmer record
            $farmer = Farmer::find($farmer_id);
            
            if (!$farmer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Farmer not found'
                ], 404);
            }
    
            // Handle image upload
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store image in public disk under products directory
            $path = $image->storeAs('farmerProfile', $imageName, 'public');
            
            // Update farmer's image path
            $farmer->image = $path;
            $farmer->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully',
                'image_path' => asset('storage/'.$path)
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_profile(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);
    
        $farmer = Farmer::find($request->person_id);
        
        if (!$farmer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Farmer not found'
            ], 404);
        }
    
        $farmer->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => $farmer->only(['name', 'phone', 'image'])
            ]);
        }
    
        public function change_password(Request $request) {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|different:current_password',
            ]);
        
            $farmer = Farmer::find($request->person_id);
            
            if (!$farmer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Farmer not found'
                ], 404);
            }
        
            // Verify current password
            if (!Hash::check($validated['current_password'], $farmer->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect'
                ], 401);
            }
        
            // Update password
            $farmer->password = Hash::make($validated['new_password']);
            $farmer->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ]);
        }
    }
