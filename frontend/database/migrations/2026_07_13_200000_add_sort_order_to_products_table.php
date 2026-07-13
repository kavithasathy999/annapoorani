<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products') || Schema::hasColumn('products', 'sort_order')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')
                ->default(0)
                ->after('product_image');
            $table->index(
                ['category_id', 'sort_order', 'id'],
                'idx_products_category_sort_order'
            );
        });

        DB::table('products')->update(['sort_order' => DB::raw('id')]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'sort_order')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_category_sort_order');
            $table->dropColumn('sort_order');
        });
    }
};
