<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('invoices')) {
            return;
        }

        if (! Schema::hasColumn('invoices', 'payment_method_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->unsignedBigInteger('payment_method_id')->nullable()->index()->after('member_id');
            });
        }

        if (! Schema::hasColumn('invoices', 'payment_method_label')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->string('payment_method_label', 191)->nullable()->after('payment_method_id');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('invoices')) {
            return;
        }

        foreach (['payment_method_label', 'payment_method_id'] as $column) {
            if (Schema::hasColumn('invoices', $column)) {
                Schema::table('invoices', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
