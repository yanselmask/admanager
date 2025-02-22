<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->datetime('invoice_date')->nullable();
                $table->decimal('amount')->nullable();
                $table->string('currency', 255)->nullable();
                $table->unsignedBigInteger('member_id')->nullable();
                $table->string('status', 60)->default('pending');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('invoices_translations')) {
            Schema::create('invoices_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('invoices_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'invoices_id'], 'invoices_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoices_translations');
    }
};
