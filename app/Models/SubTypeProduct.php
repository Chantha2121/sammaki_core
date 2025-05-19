<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTypeProduct extends Model
{
    use HasFactory;
    const TABLE = "sub_type_product";
    const ID = "id";
    const DESCRIPTION_KH = "description_kh";
    const PRODUCT_TYPE_ID = "product_type_id";

    protected $table = self::TABLE;
    protected $fillable = [
        self::DESCRIPTION_KH,
        self::PRODUCT_TYPE_ID
    ];

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, self::PRODUCT_TYPE_ID);
    }
}
