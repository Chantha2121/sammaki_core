<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'product_id',
        'status',
        'total_amount',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function product(){
        return $this->belongsTo(OurProduct::class);
    }
}
