<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contact_enquiries') || Schema::hasColumn('contact_enquiries', 'is_read')) {
            return;
        }

        Schema::table('contact_enquiries', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('message');
            $table->index(['is_read', 'created_at'], 'idx_contact_enquiries_is_read_created_at');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('contact_enquiries') || ! Schema::hasColumn('contact_enquiries', 'is_read')) {
            return;
        }

        Schema::table('contact_enquiries', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};
