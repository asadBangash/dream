<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('staff') || Schema::hasColumn('staff', 'qualification')) {
            return;
        }

        Schema::table('staff', function (Blueprint $table) {
            $table->string('qualification')->nullable()->after('department_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('staff') || ! Schema::hasColumn('staff', 'qualification')) {
            return;
        }

        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn('qualification');
        });
    }
};
