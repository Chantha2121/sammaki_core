<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //
    use HasFactory;
    const TABLE = "product_types";
    const ID = "id";
    const DESCRIPTION_KH = "description_kh";


    protected $fillable = [
        self::DESCRIPTION_KH,
    ];

    public function subTypeProducts()
    {
        return $this->hasMany(SubTypeProduct::class, SubTypeProduct::PRODUCT_TYPE_ID);
    }

    public function our_products()
    {
        return $this->hasMany(OurProduct::class, OurProduct::SUB_TYPE_ID);
    }
}
