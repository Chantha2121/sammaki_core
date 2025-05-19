<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerProduct extends Model
{
    //
    use HasFactory;
    const TABLE_NAME = 'farmer_products';
    const ID = 'id';
    const NAME = 'name';
    const IMAGE = 'image';
    const PRODUCT_DESCRIPTION = 'product_description';
    const PRICE = 'price';
    const PRODUCT_TYPE_ID = 'product_type_id';
    const ADDRESS = 'address';
    const QUANTITY = 'quantity';
    const FARMER_ID = 'farmer_id';
    const PHONE_NUM = 'contact_phone_number';
    const SUB_TYPE_PRODUCT_ID = 'sub_type_product_id';


    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::NAME,
        self::IMAGE,
        self::PRODUCT_DESCRIPTION,
        self::PRICE,
        self::PRODUCT_TYPE_ID,
        self::ADDRESS,
        self::QUANTITY,
        self::PHONE_NUM,
        self::FARMER_ID,
        self::SUB_TYPE_PRODUCT_ID
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class,'farmer_id');
    }
    public function productType()
    {
        return $this->hashMany(ProductType::TABLE, self::PRODUCT_TYPE_ID, ProductType::ID);
    }

    public function type_product(){
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
    public function sub_type_product(){
        return $this->belongsTo(SubTypeProduct::class, 'sub_type_product_id');
    }
    
    public function subTypeProduct()
    {
        return $this->hashMany(SubTypeProduct::TABLE, self::SUB_TYPE_PRODUCT_ID, SubTypeProduct::ID);
    }



    public function farmerProduct()
    {
        return $this->hashMany(FarmerProduct::TABLE_NAME, self::ID, FarmerProduct::ID);
    }

    public static function lists($filter = [])
    {
        return self::join('product_types', 'farmer_products.product_type_id', '=', 'product_types.id')
            ->join('sub_type_product', 'farmer_products.sub_type_product_id', '=', 'sub_type_product.id')
            ->when(isset($filter['product_type_id']) && $filter['product_type_id'], function ($query) use ($filter) {
                return $query->where('farmer_products.product_type_id', $filter['product_type_id']);
            })
            ->when(isset($filter['sub_type_product_id']) && $filter['sub_type_product_id'], function ($query) use ($filter) {
                return $query->where('farmer_products.sub_type_product_id', $filter['sub_type_product_id']);
            })
            ->when(isset($filter['name']) && $filter['name'], function ($query) use ($filter) {
                return $query->where('farmer_products.name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('farmer_products.description', 'like', '%' . $filter['name']. '%');
            })
            ->orderBy('created_at', 'desc')
            ->select(
                'farmer_products.*',
                'product_types.description_kh as product_type_name', 
                'sub_type_product.description_kh as sub_type_product_name'
            );
    }
    

    public static function setData($data)
    {
        return [
            self::NAME => isset($data['name']) ? $data['name'] : null,
            self::IMAGE => isset($data['image']) ? $data['image'] : null,
            self::PRODUCT_DESCRIPTION => isset($data['product_description']) ? $data['product_description'] : null,
            self::PRICE => isset($data['price']) ? $data['price'] : null,
            self::PRODUCT_TYPE_ID => isset($data['product_type_id']) ? $data['product_type_id'] : null,
            self::ADDRESS => isset($data['address']) ? $data['address'] : null,
            self::PHONE_NUM => isset($data['phone_num']) ? $data['phone_num'] : null,
            self::QUANTITY => isset($data['quantity']) ? $data['quantity'] : null,
            self::FARMER_ID => isset($data['farmer_id']) ? $data['farmer_id'] : null,
            self::SUB_TYPE_PRODUCT_ID => isset($data['sub_type_product_id']) ? $data['sub_type_product_id'] : null,
        
        ];
    }

    
   
    
    
}
