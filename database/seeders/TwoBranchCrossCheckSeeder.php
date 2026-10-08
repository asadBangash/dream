<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\Status;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Shift;
use App\Models\Role;
use App\Models\Staff\Department;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\StudentInfo\StudentCategory;
use App\Models\User;
use Database\Seeders\Demo\DemoContext;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Resets branches to Boys + Girls only, with one student per branch for isolation QA.
 *
 * php artisan db:seed --class=TwoBranchCrossCheckSeeder
 */
class TwoBranchCrossCheckSeeder extends Seeder
{
    public function run(): void
    {
        if (! hasModule('MultiBranch')) {
            $this->command?->error('MultiBranch module is not enabled.');

            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $truncateTables = [
            'marks_register_childrens', 'marks_registers', 'exam_assign_childrens', 'exam_assigns',
            'attendances', 'session_class_students', 'students', 'staff', 'parent_guardians',
            'subject_assign_childrens', 'subject_assigns', 'class_setup_childrens', 'class_setups',
            'classes', 'sections', 'subjects', 'shifts', 'departments', 'designations',
            'exam_types', 'marks_grades', 'certificates', 'id_cards', 'student_categories',
        ];

        foreach ($truncateTables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        if (Schema::hasTable('users')) {
            DB::table('users')->where('email', 'like', '%@example.com')->delete();
        }

        if (Schema::hasTable('branches')) {
            DB::table('branches')->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $boysId = (int) DB::table('branches')->insertGetId([
            'name'       => DemoContext::BOYS_BRANCH_NAME,
            'phone'      => '+92 91 5201234',
            'email'      => 'boys@dreamtuition.pk',
            'address'    => 'University Road, Peshawar, Pakistan',
            'lat'        => '34.0151',
            'long'       => '71.5249',
            'status'     => Status::ACTIVE,
            'country_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $girlsId = (int) DB::table('branches')->insertGetId([
            'name'       => DemoContext::GIRLS_BRANCH_NAME,
            'phone'      => '+92 91 5205678',
            'email'      => 'girls@dreamtuition.pk',
            'address'    => 'Saddar Road, Peshawar, Pakistan',
            'lat'        => '34.0151',
            'long'       => '71.5249',
            'status'     => Status::ACTIVE,
            'country_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DemoContext::$boysBranchId = $boysId;
        DemoContext::$girlsBranchId = $girlsId;
        DemoContext::$branchSlugs = [
            $boysId  => 'boys',
            $girlsId => 'girls',
        ];

        $adminPermissions = Role::find(RoleEnum::ADMIN)?->permissions ?? [];
        $studentPermissions = Role::find(RoleEnum::STUDENT)?->permissions ?? [];

        $this->createAdmin('boysadmin@example.com', 'Boys Branch Admin', $boysId, $adminPermissions);
        $this->createAdmin('girlsadmin@example.com', 'Girls Branch Admin', $girlsId, $adminPermissions);

        $sessionId = (int) setting('session');
        if ($sessionId < 1) {
            $sessionId = (int) DB::table('sessions')->value('id');
        }

        foreach ([$boysId => 'boys', $girlsId => 'girls'] as $branchId => $slug) {
            $isBoys = $slug === 'boys';

            $department = Department::create([
                'name'      => 'General',
                'status'    => Status::ACTIVE,
                'branch_id' => $branchId,
            ]);

            $category = StudentCategory::create([
                'name'      => 'Regular',
                'branch_id' => $branchId,
            ]);

            $shift = Shift::create([
                'name'      => 'Morning',
                'branch_id' => $branchId,
            ]);

            $section = Section::create([
                'name'      => 'A',
                'branch_id' => $branchId,
            ]);

            $class = Classes::create([
                'name'      => 'Class 8',
                'branch_id' => $branchId,
            ]);

            $parentUser = $this->createUser(
                $slug . '.parent@example.com',
                ucfirst($slug) . ' Parent',
                RoleEnum::GUARDIAN,
                $branchId,
                Role::find(RoleEnum::GUARDIAN)?->permissions ?? []
            );

            $parent = ParentGuardian::create([
                'user_id'          => $parentUser->id,
                'guardian_name'    => ucfirst($slug) . ' Parent',
                'guardian_mobile'  => '+92 300 700' . ($isBoys ? '1001' : '2002'),
                'guardian_email'   => $slug . '.parent@example.com',
                'branch_id'        => $branchId,
            ]);

            $studentUser = $this->createUser(
                $slug . '.student@example.com',
                ($isBoys ? 'Hamza' : 'Aisha') . ' Test Student',
                RoleEnum::STUDENT,
                $branchId,
                $studentPermissions
            );

            $student = Student::create([
                'user_id'             => $studentUser->id,
                'admission_no'        => strtoupper($slug) . '-TEST-001',
                'roll_no'             => 1,
                'first_name'          => $isBoys ? 'Hamza' : 'Aisha',
                'last_name'           => 'Test',
                'mobile'              => $studentUser->phone,
                'email'               => $studentUser->email,
                'dob'                 => '2011-03-10',
                'admission_date'      => now()->format('Y-m-d'),
                'department_id'       => $department->id,
                'gender_id'           => $isBoys ? 1 : 2,
                'parent_guardian_id'  => $parent->id,
                'student_category_id' => $category->id,
                'status'              => Status::ACTIVE,
                'branch_id'           => $branchId,
                'upload_documents'    => [],
            ]);

            SessionClassStudent::create([
                'session_id'  => $sessionId,
                'student_id'  => $student->id,
                'classes_id'  => $class->id,
                'section_id'  => $section->id,
                'shift_id'    => $shift->id,
                'roll'        => 1,
                'branch_id'   => $branchId,
            ]);
        }

        $this->command?->info('Branches: Boys #' . $boysId . ', Girls #' . $girlsId);
        $this->command?->table(['Role', 'Email', 'Password'], [
            ['Boys admin', 'boysadmin@example.com', DemoContext::PASSWORD],
            ['Girls admin', 'girlsadmin@example.com', DemoContext::PASSWORD],
            ['Boys student', 'boys.student@example.com', DemoContext::PASSWORD],
            ['Girls student', 'girls.student@example.com', DemoContext::PASSWORD],
        ]);
    }

    private function createAdmin(string $email, string $name, int $branchId, array $permissions): void
    {
        $this->createUser($email, $name, RoleEnum::ADMIN, $branchId, $permissions);
    }

    private function createUser(string $email, string $name, int $roleId, int $branchId, array $permissions): User
    {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->phone = '+92 300 ' . random_int(1000000, 9999999);
        $user->email_verified_at = now();
        $user->password = Hash::make(DemoContext::PASSWORD);
        $user->remember_token = Str::random(10);
        $user->role_id = $roleId;
        $user->branch_id = $branchId;
        $user->permissions = $permissions;
        $user->upload_id = 1;
        $user->uuid = Str::uuid();
        $user->save();

        return $user;
    }
}
