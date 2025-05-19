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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Farmer's name
            $table->string('phone_number', 100); // Phone number
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade'); // Foreign key to addresses table
            $table->foreignId('type_farmer_id')->constrained('type_farms')->onDelete('cascade'); // Foreign key to type_farms table
            $table->string('password'); // Password
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
 