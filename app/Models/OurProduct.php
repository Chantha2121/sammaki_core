<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurProduct extends Model
{
    use HasFactory;
    const TABLE = "our_products";
    const ID = "id";
    const NAME = "name";
    const IMAGE = "image";
    const PRODUCT_DESCRIPTION = "product_description";
    const PRICE = "price";
    const PRODUCT_TYPE_ID = "product_type_id";
    const SUB_TYPE_ID = "sub_type_product_id";

    protected $fillable = [
        self::NAME,
        self::IMAGE,
        self::PRODUCT_DESCRIPTION,
        self::PRICE,
        self::PRODUCT_TYPE_ID,
        self::SUB_TYPE_ID
    ];

    public static function lists($filter = [])
{
    return self::join('product_types', 'our_products.product_type_id', '=', 'product_types.id')
        ->join('sub_type_product', 'our_products.sub_type_product_id', '=', 'sub_type_product.id')
        ->when(isset($filter['product_type_id']) && $filter['product_type_id'], function ($query) use ($filter) {
            return $query->where('our_products.product_type_id', $filter['product_type_id']);
        })
        ->when(isset($filter['sub_type_product_id']) && $filter['sub_type_product_id'], function ($query) use ($filter) {
            return $query->where('our_products.sub_type_product_id', $filter['sub_type_product_id']);
        })
        ->when(isset($filter['min_price']) && $filter['min_price'], function ($query) use ($filter) {
            return $query->where('our_products.price', '>=', $filter['min_price']);
        })
        ->when(isset($filter['max_price']) && $filter['max_price'], function ($query) use ($filter) {
            return $query->where('our_products.price', '<=', $filter['max_price']);
        })
        ->when(isset($filter['name']) && $filter['name'], function ($query) use ($filter) {
            return $query->where('our_products.name', 'like', '%' . $filter['name'] . '%');
        })
        ->orderBy('created_at', 'desc')
        ->select(
            'our_products.*',
            'product_types.description_kh as product_type_name', 
            'sub_type_product.description_kh as sub_type_product_name'
        );
}
   

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
    public function subTypeProduct()
    {
        return $this->belongsTo(SubTypeProduct::class, 'sub_type_product_id');
    }

    public function product_type(){
        return $this->hasMany(ProductType::class, ProductType::ID, self::PRODUCT_TYPE_ID);
    }
    public function sub_type_product(){
        return $this->hasMany(SubTypeProduct::class, SubTypeProduct::ID, self::SUB_TYPE_ID);
    }

    public function typeProduct()
    {
        return $this->belongsTo(ProductType::class);
    }


    
}
