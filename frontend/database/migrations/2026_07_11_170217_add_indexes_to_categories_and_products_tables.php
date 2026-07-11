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
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['status', 'category_name']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['category_id', 'product_regular_price', 'product_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['categories_status_category_name_index']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['products_category_id_product_regular_price_product_name_index']);
        });
    }
};
