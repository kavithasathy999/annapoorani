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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('show_mrp_in_pdf')->default(true)->after('product_regular_price');
            $table->boolean('show_discount_in_pdf')->default(true)->after('show_mrp_in_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['show_mrp_in_pdf', 'show_discount_in_pdf']);
        });
    }
};
