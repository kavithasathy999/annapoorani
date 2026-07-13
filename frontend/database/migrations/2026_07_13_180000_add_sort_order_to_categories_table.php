<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('categories', 'sort_order')) {
            return;
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')
                ->default(0)
                ->after('category_image')
                ->index();
        });

        DB::table('categories')->update(['sort_order' => DB::raw('id')]);
    }

    public function down(): void
    {
        if (!Schema::hasColumn('categories', 'sort_order')) {
            return;
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
