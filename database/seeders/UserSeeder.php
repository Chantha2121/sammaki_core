<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Choeurn Chantha',
            'email' => 'chantha@gmail.com',
            'password' => Hash::make('chantha1234'), // never store plain text passwords
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
