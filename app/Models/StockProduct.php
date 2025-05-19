<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'product_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function product(){
        return $this->belongsTo(OurProduct::class);
    }
}
