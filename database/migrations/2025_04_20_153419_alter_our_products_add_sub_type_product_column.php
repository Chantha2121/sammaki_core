<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('our_products', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_type_product_id')->after('product_type_id');
            $table->dropColumn('meat_type_id');
            $table->dropColumn('vegetable_type_id');
            $table->dropColumn('fruit_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('our_products', function (Blueprint $table) {
            $table->dropColumn('sub_type_product_id');
            $table->unsignedBigInteger('meat_type_id')->after('product_type_id')->nullable();
            $table->unsignedBigInteger('vegetable_type_id')->after('meat_type_id')->nullable();
            $table->unsignedBigInteger('fruit_type_id')->after('vegetable_type_id')->nullable();
        });
    }
};
