<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFarm extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'description_kh', 
        'created_at', 
        'updated_at',
    ];

    public function subTypes(){
        return $this->hasMany(SubTypeFarm::class, 'type_farm_id');
    }
}
