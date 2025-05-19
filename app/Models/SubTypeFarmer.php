<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTypeFarmer extends Model
{
    use HasFactory;
    const TABLE_NAME = 'sub_type_famer';
    const ID = 'id';
    const DESCRIPTION_KH = 'description_kh';
    const TYPE_FARMER_ID = 'type_farmer_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::DESCRIPTION_KH,
        self::TYPE_FARMER_ID,
    ];

    public function typeFarmer()
    {
        return $this->hasMany(TypeFarm::class, self::TYPE_FARMER_ID);
    }

    public function type_farmer()
    {
        return $this->belongsTo(TypeFarm::class, self::TYPE_FARMER_ID);
    }

    public function our_products()
    {
        return $this->hasMany(OurProduct::class, OurProduct::SUB_TYPE_ID);
    }
}
