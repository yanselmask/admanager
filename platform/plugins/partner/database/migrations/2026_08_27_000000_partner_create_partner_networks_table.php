<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('partner_networks')) {
            Schema::create('partner_networks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('member_id')->index();
                $table->string('network_code', 60)->unique();
                $table->decimal('commission', 12, 2)->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('members')) {
            if (! Schema::hasColumn('members', 'role')) {
                Schema::table('members', function (Blueprint $table) {
                    $table->string('role', 20)->default('creator')->index()->after('status');
                });
            }

            if (! Schema::hasColumn('members', 'commission')) {
                Schema::table('members', function (Blueprint $table) {
                    $table->decimal('commission', 12, 2)->nullable()->after('role');
                });
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_networks');

        if (Schema::hasTable('members')) {
            foreach (['commission', 'role'] as $column) {
                if (Schema::hasColumn('members', $column)) {
                    Schema::table('members', function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    });
                }
            }
        }
    }
};
