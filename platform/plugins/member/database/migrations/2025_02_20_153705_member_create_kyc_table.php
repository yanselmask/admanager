<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('kycs')) {
            Schema::create('kycs', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->nullable();
                $table->string('last_name', 255)->nullable();
                $table->string('address', 255)->nullable();
                $table->string('nationality', 100)->nullable();
                $table->string('document_type', 100)->nullable();
                $table->string('document_number', 100)->nullable();
                $table->string('document_front', 255)->nullable();
                $table->string('document_back', 255)->nullable();
                $table->string('selfie', 255)->nullable();

                $table->unsignedBigInteger('member_id')->nullable();

                $table->string('status', 60)->default('pending');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('kycs_translations')) {
            Schema::create('kycs_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('kycs_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'kycs_id'], 'kycs_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kycs');
        Schema::dropIfExists('kycs_translations');
    }
};
