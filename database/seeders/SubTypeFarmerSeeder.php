<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TypeFarm;

class SubTypeFarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type_farmer_id = TypeFarm::pluck('id')->toArray();
        
        DB::table('sub_type_famer')->insert([
            [
                'description_kh' => 'សត្វគោ',
                'type_farmer_id' => $type_farmer_id[array_rand($type_farmer_id)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'description_kh' => 'សត្វមាន់',
                'type_farmer_id' => $type_farmer_id[array_rand($type_farmer_id)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'description_kh' => 'សត្វជ្រូក',
                'type_farmer_id' => $type_farmer_id[array_rand($type_farmer_id)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
