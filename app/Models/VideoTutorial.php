<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{
    //
    const TABLE_NAME = 'video_tutorials';
    const ID = 'id';
    const TITLE = 'title';
    const VIDEO = 'video';
    const IMAGE = 'image';
    const DESCRIPTION = 'description';
    const SUB_TYPE_ID = 'sub_type_id';
    const TYPE_FARM_ID = 'type_farm_id';
    protected $table = self::TABLE_NAME;
    protected $fillable = [
        self::TITLE,
        self::VIDEO,
        self::IMAGE,
        self::DESCRIPTION,
        self::TYPE_FARM_ID,
        self::SUB_TYPE_ID,
    ];

    public function typeFarm()
    {
        return $this->belongsTo(TypeFarm::class);
    }

    public function subType()
    {
        return $this->hasMany(SubTypeFarmer::class, self::SUB_TYPE_ID );
    }

    public static function Lists($filter = [], $num_video = 10)
    {
        return self::when(isset($filter['type_video']) && $filter['type_video'], function ($query) use ($filter) {
                $query->where('type_farm_id', $filter['type_video']);
            })
            ->when(isset($filter['sub_type']) && $filter['sub_type'], function ($query) use ($filter) {
                $query->where('sub_type_id', $filter['sub_type']);
            })
            ->when(isset($filter['title']) && $filter['title'], function ($query) use ($filter) {
                $query->where('title', 'like', '%' . $filter['title'] . '%');
            })
            ->when(isset($filter['description']) && $filter['title'], function ($query) use ($filter) {
                $query->where('description', 'like', '%' . $filter['title'] . '%');
            })
            ->orderBy('created_at', 'desc')
            ->limit($num_video)
            ->select(
                'id',
                'title',
                'video as code',
                'image',
                'description'
            )
            ->get();
    }
}
