<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('link', 255)->nullable();
                $table->string('image_url', 255)->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('brands_translations')) {
            Schema::create('brands_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('brands_id');
                $table->string('name', 255)->nullable();
                $table->string('link', 255)->nullable();
                $table->string('image_url', 255)->nullable();

                $table->primary(['lang_code', 'brands_id'], 'brands_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('brands_translations');
    }
};
