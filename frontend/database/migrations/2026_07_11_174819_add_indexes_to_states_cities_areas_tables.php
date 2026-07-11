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
        Schema::table('city_list', function (Blueprint $table) {
            $table->index('city_name');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->index('area_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('city_list', function (Blueprint $table) {
            $table->dropIndex(['city_list_city_name_index']);
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropIndex(['areas_area_name_index']);
        });
    }
};
