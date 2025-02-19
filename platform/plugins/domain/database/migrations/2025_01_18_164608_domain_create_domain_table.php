<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('domains')) {
            Schema::create('domains', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('url', 255);
                $table->string('network_code', 255);
                $table->decimal('commissions', 12, 2)->nullable();
                $table->boolean('is_subdomain')->default(false);
                $table->json('earnings')->nullable();
                $table->json('impressions')->nullable();
                $table->json('ecpms')->nullable();
                $table->json('clicks')->nullable();
                $table->json('ctrs')->nullable();
                $table->unsignedBigInteger('member_id')->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('domains_translations')) {
            Schema::create('domains_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('domains_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'domains_id'], 'domains_translations_primary');
            });
        }

        if(Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->unsignedBigInteger('ref_by')->nullable()->after('id');
                $table->string('username',60)->after('ref_by');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
        Schema::dropIfExists('domains_translations');
        if(Schema::hasTable('members')) {
            Schema::dropColumns('members', ['ref_by', 'username']);
        }
    }
};
