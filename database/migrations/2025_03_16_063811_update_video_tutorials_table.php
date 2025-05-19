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
        Schema::table('video_tutorials', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['meat_type_id']);
            $table->dropForeign(['vegetable_type_id']);
            $table->dropForeign(['fruit_type_id']);
            $table->dropForeign(['product_type_id']);

            // Drop old columns
            $table->dropColumn(['meat_type_id', 'vegetable_type_id', 'fruit_type_id', 'product_type_id']);

            // Add new columns
            $table->foreignId('crop_type_id')->nullable()->constrained('crop_types')->onDelete('set null');
            $table->foreignId('feeding_type_id')->nullable()->constrained('feedingtypes')->onDelete('set null');
            $table->foreignId('type_farm_id')->constrained('type_farms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_tutorials', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['crop_type_id']);
            $table->dropForeign(['feeding_type_id']);
            $table->dropForeign(['type_farm_id']);

            $table->dropColumn(['crop_type_id', 'feeding_type_id', 'type_farm_id']);

            // Restore old columns
            $table->foreignId('meat_type_id')->nullable()->constrained('meat_types')->onDelete('set null');
            $table->foreignId('vegetable_type_id')->nullable()->constrained('vegetable_types')->onDelete('set null');
            $table->foreignId('fruit_type_id')->nullable()->constrained('fruit_types')->onDelete('set null');
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade');
        });
    }
};
