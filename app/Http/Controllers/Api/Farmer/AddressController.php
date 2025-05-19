<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    //
    public function index(){
        $addresses = Address::all();
        return response()->json([
            "data" => $addresses
        ]);
    }
}
