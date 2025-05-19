<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoTutorial;
use App\Models\CropType;
use App\Models\FeedingType;
use App\Models\TypeFarm;
use App\Models\SubTypeFarmer;

class VideoController extends Controller
{
    //

    public function index()
    {
        $videolimit = VideoTutorial::orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json([
            'data' => $videolimit
        ]);
    }

    public function searchVideobyname(Request $request, $name)
    {
        $video = VideoTutorial::where('title', 'like', "%{$name}%")
            ->orWhere('description', 'like', "%{$name}%")
            ->get();

        return response()->json([
            'data' => $video
        ]);
    }

    public function getVideobyCategory(Request $request)
    {
        $validated = $request->validate([
            'type_video' => 'required|string',
            'sub_type' => 'required|string'
        ]);

        $croptype_id = CropType::where('description_kh', $validated['sub_type'])->value('id');
        $feedingtype_id = FeedingType::where('description_kh', $validated['sub_type'])->value('id');
        $farm_type_id = TypeFarm::where('description_kh', $validated['type_video'])->value('id');

        $video = VideoTutorial::where('id', $farm_type_id);

        if ($croptype_id) {
            $video->orWhere('crop_type_id', $croptype_id);
        } elseif ($feedingtype_id) {
            $video->orWhere('feeding_type_id', $feedingtype_id);
        }

        return response()->json([
            "data" => $video->get()
        ]);
    }

    public function get(Request $request)
    {
        $filter = $request->input('filter');
        $num_video = $request->input('number_video');

        $video = VideoTutorial::Lists($filter, $num_video);
        return response()->json([
            'data' => $video
        ]);
    }

    public function getVideoById($id)
    {
        $video = VideoTutorial::find($id);
        if ($video) {
            return response()->json([
                'data' => $video
            ]);
        } else {
            return response()->json([
                'message' => 'Video not found'
            ], 404);
        }
    }

    public function getSubTypeVideo(Request $request)
    {
        return response()->json([
            'data' => SubTypeFarmer::all(),
        ]);
    }
}
