<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
class ProductController extends Controller
{
    //
    public function index(Request $request){
        $id = $request->person_id;
        $farmer = Farmer::where('id', $id)->first();

        return response()->json([
            "farmer" => $farmer,
        ]);

    }
}
