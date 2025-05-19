<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FarmerProduct;
use Illuminate\Support\Facades\DB;
use App\Models\ProductType;
use App\Models\SubTypeProduct;

class FarmerProductController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $farmer_id = $request->person_id;
    
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'product_description' => 'required|string|max:500',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'product_type_id' => 'required|exists:product_types,id',
                'sub_type_product_id' => 'required|exists:sub_type_product,id',
                'address' => 'required|string|max:1000',
                'contact_phone_number'=> 'required|string|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store image using the 'public' disk with correct path
            $path = $image->storeAs('products', $imageName, 'public');
            $validatedData['image'] = $path;
    
            $farmerProduct = new FarmerProduct();
            $farmerProduct->fill($validatedData);
            $farmerProduct->farmer_id = $farmer_id;
            $farmerProduct->save();
    
            DB::commit();
    
            return response()->json([
                'data' => $farmerProduct,
                'message' => 'Product created successfully'
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error creating product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function get_productType(Request $request)
    {
        $productTypes = ProductType::with('subTypeProducts')->get();
        
        return response()->json([
            'data' => [
                'product_types' => $productTypes,
                'sub_type_products' => SubTypeProduct::all()
            ]
        ]);
    }

    public function get_product_by_farmer(Request $request){
        $farmer_id = $request->person_id;
        $product_farmer = FarmerProduct::where('farmer_id',$farmer_id)->get();

        return response()->json([
            $farmer_id,
            'data'=> $product_farmer
        ]);
    }

    public function get(Request $request)
    {
        $validated = $request->validate([
            'filter.product_type_id' => 'nullable|integer',
            'filter.sub_type_product_id' => 'nullable|integer',
            'filter.name' => 'nullable|string',
            'filter.page' => 'nullable|integer|min:1',
        ]);
    
        $filter = $validated['filter'] ?? [];
        $page = $filter['page'] ?? 1;
        
        $products = FarmerProduct::lists($filter)->paginate(8, ['*'], 'page', $page);
        
        return response()->json([
            "data" => $products->items(),
            "meta" => [
                "current_page" => $products->currentPage(),
                "total_pages" => $products->lastPage(),
                "total_items" => $products->total(),
            ],
            "message" => $products->isEmpty() ? "No data found" : "Products retrieved successfully"
        ]);
    }
}
