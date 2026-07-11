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
        Schema::table('product_slots', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('user_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_slots', function (Blueprint $table) {
            $table->dropIndex(['product_slots_order_id_index']);
            $table->dropIndex(['product_slots_user_id_index']);
            $table->dropIndex(['product_slots_product_id_index']);
        });
    }
};
