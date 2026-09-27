<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('members') && ! Schema::hasColumn('members', 'partner_visibility')) {
            Schema::table('members', function (Blueprint $table) {
                $table->text('partner_visibility')->nullable()->after('commission');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('members') && Schema::hasColumn('members', 'partner_visibility')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('partner_visibility');
            });
        }
    }
};
