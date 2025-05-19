<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    // Add a new product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount_type' => 'required|in:$,%',
            'discount_amount' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        $priceAfterTax = $request->price + ($request->price * $request->tax / 100);
        $discount = $request->discount_type == '%' ? 
                    ($priceAfterTax * $request->discount_amount / 100) : 
                    $request->discount_amount;
        $finalPrice = ($priceAfterTax - $discount) * $request->qty;

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'photo' => $request->photo,
            'price' => $request->price,
            'tax' => $request->tax,
            'price_after_tax' => $priceAfterTax,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'total_price' => $priceAfterTax - $discount,
            'qty' => $request->qty,
            'final_price' => $finalPrice,
        ]);

        return response()->json($product, 201);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount_type' => 'required|in:$,%',
            'discount_amount' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        $priceAfterTax = $request->price + ($request->price * $request->tax / 100);
        $discount = $request->discount_type == '%' ? 
                    ($priceAfterTax * $request->discount_amount / 100) : 
                    $request->discount_amount;
        $finalPrice = ($priceAfterTax - $discount) * $request->qty;

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'photo' => $request->photo,
            'price' => $request->price,
            'tax' => $request->tax,
            'price_after_tax' => $priceAfterTax,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'total_price' => $priceAfterTax - $discount,
            'qty' => $request->qty,
            'final_price' => $finalPrice,
        ]);

        return response()->json($product, 200);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
