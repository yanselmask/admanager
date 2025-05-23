<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->string('status', 60)->default('published');
        });
    }

    public function down(): void
    {
        if(Schema::hasTable('teams'))
        {
            Schema::table('teams', function (Blueprint $table): void {
                $table->dropColumn('status');
            });
        }
    }
};
