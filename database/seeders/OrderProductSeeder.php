<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\OurProduct;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get random customer and product IDs
        $customerIds = Customer::pluck('id')->toArray();
        $productIds = OurProduct::pluck('id')->toArray();

        if (empty($customerIds) || empty($productIds)) {
            return; // Avoid errors if tables are empty
        }

        // Insert sample data
        DB::table('order_products')->insert([
            [
                'customer_id'  => $customerIds[array_rand($customerIds)],
                'product_id'   => $productIds[array_rand($productIds)],
                'status'       => true,
                'total_amount' => 199.99,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'customer_id'  => $customerIds[array_rand($customerIds)],
                'product_id'   => $productIds[array_rand($productIds)],
                'status'       => false,
                'total_amount' => 89.50,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
