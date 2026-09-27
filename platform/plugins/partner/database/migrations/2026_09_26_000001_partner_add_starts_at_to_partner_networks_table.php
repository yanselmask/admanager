<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Una network puede cambiar de partner a partir de una fecha: deja de ser única y
 * cada asignación guarda desde cuándo aplica (`null` = desde siempre).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('partner_networks') || Schema::hasColumn('partner_networks', 'starts_at')) {
            return;
        }

        Schema::table('partner_networks', function (Blueprint $table) {
            $table->dropUnique(['network_code']);
        });

        Schema::table('partner_networks', function (Blueprint $table) {
            $table->index('network_code');
            $table->date('starts_at')->nullable()->after('network_code');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('partner_networks') || ! Schema::hasColumn('partner_networks', 'starts_at')) {
            return;
        }

        Schema::table('partner_networks', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropIndex(['network_code']);
        });

        Schema::table('partner_networks', function (Blueprint $table) {
            $table->unique('network_code');
        });
    }
};
