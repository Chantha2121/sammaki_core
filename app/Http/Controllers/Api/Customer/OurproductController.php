<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurProduct;
use App\Models\ProductType;
use App\Models\SubTypeProduct;

class OurproductController extends Controller
{
    public function get(Request $request)
    {
        $validated = $request->validate([
            'filter.product_type_id' => 'nullable|integer',
            'filter.sub_type_product_id' => 'nullable|integer',
            'filter.price' => 'nullable|numeric',
            'filter.name' => 'nullable|string',
            'filter.product_description' => 'nullable|string',
            'filter.page' => 'nullable|integer|min:1',
        ]);
    
        $filter = $validated['filter'] ?? [];
        $page = $filter['page'] ?? 1;
        
        $products = OurProduct::lists($filter)->paginate(8, ['*'], 'page', $page);
        
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

    public function get_productType(Request $request)
    {
        return response()->json([
            'product_types' => ProductType::all(),
            'sub_type_products' => SubTypeProduct::all(),
        ]);
    }
}
