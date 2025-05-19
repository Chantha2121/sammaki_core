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
        Schema::create('our_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Product name
            $table->string('image', 255); // Image path
            $table->string('product_description', 500); // Product description
            $table->float('price'); // Product price
            $table->foreignId('meat_type_id')->nullable()->constrained('meat_types')->onDelete('set null'); // Nullable foreign key to meat_types
            $table->foreignId('vegetable_type_id')->nullable()->constrained('vegetable_types')->onDelete('set null'); // Nullable foreign key to vegetable_types
            $table->foreignId('fruit_type_id')->nullable()->constrained('fruit_types')->onDelete('set null'); // Nullable foreign key to fruit_types
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade'); // Required foreign key to product_types
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_products');
    }
};
