<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanDatabaseFresh extends Command
{
    protected $signature = 'db:clean-fresh {--force : Confirm destructive clean}';

    protected $description = 'Clear academic and operational school data; keep Super Admin, branch admins, branches, roles, and system settings';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->error('This removes students, staff, classes, sessions, fees, exams, and related records.');
            $this->line('Run: php artisan db:clean-fresh --force');

            return self::FAILURE;
        }

        $superAdminIds = DB::table('users')->where('role_id', RoleEnum::SUPERADMIN)->pluck('id')->all();

        if ($superAdminIds === []) {
            $this->error('No Super Admin user found. Aborting.');

            return self::FAILURE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $truncateTables = [
            'marks_register_childrens', 'marks_registers', 'mark_sheet_approvals',
            'exam_assign_childrens', 'exam_assigns', 'exam_routines', 'exam_routine_childrens',
            'exam_results', 'examination_results', 'examination_settings',
            'attendances', 'subject_attendances',
            'online_exam_children_questions', 'online_exam_children_students', 'online_exams',
            'answers', 'question_bank_childrens', 'question_banks', 'question_groups',
            'session_class_students', 'promote_students',
            'students', 'staff', 'parent_guardians',
            'subject_assign_childrens', 'subject_assigns',
            'class_routine_childrens', 'class_routines',
            'class_setup_childrens', 'class_setups',
            'class_translates', 'class_section_translates', 'section_translates', 'shift_translates',
            'session_translates', 'sessions',
            'classes', 'sections', 'subjects', 'shifts', 'time_schedules', 'class_rooms',
            'departments', 'designations', 'student_categories',
            'exam_types', 'marks_grades', 'certificates', 'id_cards',
            'fees_collects', 'fees_assign_childrens', 'fees_assigns', 'fees_masters', 'fees_groups', 'fees_types',
            'assign_fees_discounts', 'early_payment_discounts', 'sibling_fees_discounts',
            'homework_students', 'homework',
            'leave_requests', 'online_admissions', 'online_admission_payments', 'talent_test_applications',
            'system_notifications', 'sms_mail_logs',
        ];

        foreach ($truncateTables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line("truncated: {$table}");
            }
        }

        if (Schema::hasTable('users')) {
            DB::table('users')
                ->whereNotIn('id', $superAdminIds)
                ->whereNotIn('role_id', [RoleEnum::ADMIN])
                ->delete();

            DB::table('users')->where('email', 'like', '%@example.com')->delete();

            $this->info('Kept Super Admin and branch admin users.');
            $this->line('Super Admin: ' . implode(', ', DB::table('users')->whereIn('id', $superAdminIds)->pluck('email')->all()));
        }

        if (Schema::hasTable('settings') && Schema::hasColumn('settings', 'name')) {
            DB::table('settings')->where('name', 'session')->delete();
            $this->line('cleared: settings.session (create a new session in admin)');
        }

        foreach (['personal_access_tokens', 'jobs', 'failed_jobs'] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        session()->forget('active_branch_id');

        $branchCount = Schema::hasTable('branches') ? DB::table('branches')->count() : 0;
        $this->newLine();
        $this->info("Done. Branches kept: {$branchCount}. Log in as Super Admin and add sessions, classes, sections, then branch data.");

        return self::SUCCESS;
    }
}
