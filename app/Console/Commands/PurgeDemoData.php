<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurgeDemoData extends Command
{
    protected $signature = 'demo:purge {--force : Required to run}';

    protected $description = 'Remove demo users (@example.com) and related academic records; keeps schema and settings';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->error('This deletes demo data. Run with --force');

            return self::FAILURE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            'marks_register_childrens', 'marks_registers', 'exam_assign_childrens', 'exam_assigns',
            'attendances', 'session_class_students', 'students', 'staff', 'parent_guardians',
            'subject_assign_childrens', 'subject_assigns', 'class_setup_childrens', 'class_setups',
            'classes', 'sections', 'subjects', 'shifts', 'departments', 'designations',
            'exam_types', 'marks_grades', 'certificates', 'id_cards', 'student_categories',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line("truncated: {$table}");
            }
        }

        if (Schema::hasTable('users')) {
            DB::table('users')->where('email', 'like', '%@example.com')->delete();
            DB::table('users')->where('email', 'like', '%@gmail.com')->where('role_id', '>', 1)->delete();
        }

        if (Schema::hasTable('branches')) {
            DB::table('branches')->where('id', '>', 2)->delete();
            DB::table('branches')->where('id', 1)->update(['name' => 'Main Campus']);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Demo data purged. Super Admin and system settings retained.');

        return self::SUCCESS;
    }
}
