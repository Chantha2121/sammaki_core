<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeFarm;

class TypeFarmController extends Controller
{
    //
    public function index(){
        $typeFarms = TypeFarm::all();
        return response()->json([
            "data" => $typeFarms
        ]);
    }
}
