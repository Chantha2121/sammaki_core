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
            $table->unsignedBigInteger('sub_type_id')->after('type_id')->nullable();
            $table->dropColumn('crop_type_id');
            $table->dropColumn('feeding_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_tutorial', function (Blueprint $table) {
            $table->dropColumn('sub_type_id');
            $table->unsignedBigInteger('crop_type_id')->after('type_id')->nullable();
            $table->unsignedBigInteger('feeding_type_id')->after('crop_type_id')->nullable();
        });
    }
};
