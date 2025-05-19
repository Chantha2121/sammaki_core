<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Farmer extends Model
{
    use HasApiTokens, Notifiable;

    const TABLE_NAME = 'farmers';
    const ID = 'id';
    const NAME = 'name';
    const PHONE_NUMBER = 'phone_number';
    const PASSWORD = 'password';
    const ADDRESS_ID = 'address_id';
    const TYPE_FARMER_ID = 'type_farmer_id';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        self::NAME,
        self::PHONE_NUMBER,
        self::PASSWORD,
        self::ADDRESS_ID,
        self::TYPE_FARMER_ID
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function typeFarmer(){
        return $this->belongsTo(TypeFarm::class);
    }
}
