<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Enums\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabaseForManualEntry extends Command
{
    protected $signature = 'db:reset-manual {--force : Confirm destructive reset}';

    protected $description = 'Clear operational data; keep Super Admin user(s) and a single branch for manual entry';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->error('This removes almost all school data and all users except Super Admin. Run with --force');

            return self::FAILURE;
        }

        $superAdminIds = DB::table('users')->where('role_id', RoleEnum::SUPERADMIN)->pluck('id')->all();

        if ($superAdminIds === []) {
            $this->error('No Super Admin user (role_id=1) found. Aborting.');

            return self::FAILURE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $truncateTables = [
            'marks_register_childrens', 'marks_registers', 'exam_assign_childrens', 'exam_assigns',
            'exam_results', 'examination_results', 'attendances', 'session_class_students',
            'students', 'staff', 'parent_guardians',
            'subject_assign_childrens', 'subject_assigns', 'class_setup_childrens', 'class_setups',
            'classes', 'sections', 'subjects', 'shifts', 'departments', 'designations',
            'exam_types', 'marks_grades', 'certificates', 'id_cards', 'student_categories',
            'fees_assign_childrens', 'fees_assigns', 'fees_masters', 'fees_groups', 'fees_types',
            'assign_fees_discounts', 'homework_students', 'homeworks',
            'online_exams', 'question_banks', 'question_groups',
            'promote_students', 'leave_requests', 'notice_boards',
        ];

        foreach ($truncateTables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line("truncated: {$table}");
            }
        }

        $keepBranchId = 1;

        if (Schema::hasTable('branches')) {
            $keepBranchId = (int) DB::table('branches')->min('id');

            if ($keepBranchId < 1) {
                $keepBranchId = (int) DB::table('branches')->insertGetId([
                    'name'       => 'Main Branch',
                    'phone'      => '',
                    'email'      => '',
                    'address'    => '',
                    'status'     => Status::ACTIVE,
                    'country_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->info("Created branch id={$keepBranchId} (Main Branch)");
            } else {
                DB::table('branches')->where('id', '!=', $keepBranchId)->delete();
                DB::table('branches')->where('id', $keepBranchId)->update([
                    'name'       => 'Main Branch',
                    'updated_at' => now(),
                ]);
                $this->info("Kept single branch id={$keepBranchId} (Main Branch)");
            }
        }

        if (Schema::hasTable('users')) {
            DB::table('users')->whereNotIn('id', $superAdminIds)->delete();
            if (Schema::hasColumn('users', 'branch_id')) {
                DB::table('users')->whereIn('id', $superAdminIds)->update(['branch_id' => $keepBranchId]);
            }
            $this->info('Kept Super Admin user(s): ' . implode(', ', DB::table('users')->whereIn('id', $superAdminIds)->pluck('email')->all()));
        }

        if (Schema::hasTable('personal_access_tokens')) {
            DB::table('personal_access_tokens')->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        session()->forget('active_branch_id');

        $this->newLine();
        $this->info('Done. Super Admin + one branch remain. Settings, roles, and sessions table were not wiped.');
        $this->line('Log in as Super Admin, pick the branch in the header, then add class/section/students manually.');

        return self::SUCCESS;
    }
}
