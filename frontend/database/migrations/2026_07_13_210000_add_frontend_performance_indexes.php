<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->index(
                ['status', 'sort_order', 'category_name'],
                'idx_categories_status_sort_order'
            );
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'idx_brands_active_sort_order');
        });

        Schema::table('banner_images', function (Blueprint $table) {
            $table->index('banner_position', 'idx_banner_images_position');
        });

        Schema::table('city_list', function (Blueprint $table) {
            $table->index(['state_code', 'city_name'], 'idx_city_list_state_name');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->index(['city_id', 'area_name'], 'idx_areas_city_name');
        });

        Schema::table('additional_charges', function (Blueprint $table) {
            $table->index('city_id', 'idx_additional_charges_city');
        });

        Schema::table('seo_datas', function (Blueprint $table) {
            $table->index('url', 'idx_seo_datas_url');
            $table->index('seo_headingId', 'idx_seo_datas_heading');
        });
    }

    public function down(): void
    {
        Schema::table('seo_datas', function (Blueprint $table) {
            $table->dropIndex('idx_seo_datas_url');
            $table->dropIndex('idx_seo_datas_heading');
        });

        Schema::table('additional_charges', function (Blueprint $table) {
            $table->dropIndex('idx_additional_charges_city');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropIndex('idx_areas_city_name');
        });

        Schema::table('city_list', function (Blueprint $table) {
            $table->dropIndex('idx_city_list_state_name');
        });

        Schema::table('banner_images', function (Blueprint $table) {
            $table->dropIndex('idx_banner_images_position');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('idx_brands_active_sort_order');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_status_sort_order');
        });
    }
};
