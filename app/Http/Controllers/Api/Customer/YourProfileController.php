<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class YourProfileController extends Controller
{
    public function get(Request $request){
        $customer_id = $request->person_id;

        $data = Customer::where('id', $customer_id)->first();
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
    
            $customer_id = $request->person_id;
            
            // Get the customer record
            $customer = Customer::find($customer_id);
            
            if (!$customer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Customer not found'
                ], 404);
            }
    
            // Handle image upload
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store image in public disk under products directory
            $path = $image->storeAs('customerProfile', $imageName, 'public');
            
            // Update customer's image path
            $customer->image = $path;
            $customer->save();
    
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
    
        $customer = Customer::find($request->person_id);
        
        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer not found'
            ], 404);
        }
    
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => $customer->only(['name', 'phone', 'image'])
            ]);
        }
    
        public function change_password(Request $request) {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|different:current_password',
            ]);
        
            $customer = Customer::find($request->person_id);
            
            if (!$c) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'C not found'
                ], 404);
            }
        
            // Verify current password
            if (!Hash::check($validated['current_password'], $c->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect'
                ], 401);
            }
        
            // Update password
            $c->password = Hash::make($validated['new_password']);
            $c->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ]);
        }
}
