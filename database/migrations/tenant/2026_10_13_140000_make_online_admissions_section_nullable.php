<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('online_admissions') || ! Schema::hasColumn('online_admissions', 'section_id')) {
            return;
        }

        DB::statement('ALTER TABLE online_admissions MODIFY section_id BIGINT UNSIGNED NULL');

        if (Schema::hasTable('classes') && Schema::hasColumn('online_admissions', 'branch_id')) {
            DB::statement('
                UPDATE online_admissions o
                INNER JOIN classes c ON o.classes_id = c.id
                SET o.branch_id = c.branch_id
                WHERE c.branch_id IS NOT NULL AND c.branch_id > 0
            ');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('online_admissions') || ! Schema::hasColumn('online_admissions', 'section_id')) {
            return;
        }

        DB::statement('ALTER TABLE online_admissions MODIFY section_id BIGINT UNSIGNED NOT NULL');
    }
};
