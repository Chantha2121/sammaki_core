<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert sample customer data
        DB::table('customers')->insert([
            [
                'name'         => 'John Doe',
                'email'        => 'johndoe@example.com',
                'phone_number' => '1234567890',
                'password'     => Hash::make('password123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Jane Smith',
                'email'        => 'janesmith@example.com',
                'phone_number' => '0987654321',
                'password'     => Hash::make('password123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // Generate additional fake customers
        foreach (range(1, 8) as $index) {
            DB::table('customers')->insert([
                'name'         => $faker->name,
                'email'        => $faker->unique()->safeEmail,
                'phone_number' => $faker->unique()->phoneNumber,
                'password'     => Hash::make('password123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
