<?php

namespace Database\Seeders\Demo;

use App\Enums\RoleEnum;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoPeopleSeeder extends Seeder
{
    public static int $boysStudentUserId = 0;

    public static int $girlsStudentUserId = 0;

    public static int $boysTeacherUserId = 0;

    public static int $girlsTeacherUserId = 0;

    public static int $studentCount = 0;

    public static int $staffCount = 0;

    private array $boysFirstNames = ['Hamza', 'Usman', 'Bilal', 'Saad', 'Arslan', 'Fahad', 'Imran', 'Kamran', 'Nabeel', 'Omar'];

    private array $girlsFirstNames = ['Aisha', 'Fatima', 'Hira', 'Iqra', 'Khadija', 'Laiba', 'Mariam', 'Nida', 'Sana', 'Zainab'];

    private array $lastNames = ['Khan', 'Shah', 'Afridi', 'Khattak', 'Yousafzai', 'Ali', 'Hussain'];

    public function run(): void
    {
        $sessionId = (int) setting('session');

        foreach (DemoContext::branches() as $branchId => $branchName) {
            $slug = DemoContext::slugForBranch($branchId);
            $isBoys = $slug === 'boys';
            $firstNames = $isBoys ? $this->boysFirstNames : $this->girlsFirstNames;

            $parents = $this->seedParents($branchId, $slug, 15);

            $staffMap = $this->seedStaff($branchId, $slug, $isBoys);

            if ($isBoys) {
                self::$boysTeacherUserId = $staffMap['Teacher'];
            } else {
                self::$girlsTeacherUserId = $staffMap['Teacher'];
            }

            $classKeys = array_keys(DemoAcademicSeeder::$classesByBranch[$branchId]);
            $studentIndex = 1;

            foreach ($classKeys as $classKey) {
                $classId = DemoAcademicSeeder::$classesByBranch[$branchId][$classKey];

                foreach (['A', 'B'] as $sectionName) {
                    $sectionId = DemoAcademicSeeder::$sectionsByBranch[$branchId][$sectionName];

                    for ($i = 0; $i < 4; $i++) {
                        $first = $firstNames[($studentIndex + $i) % count($firstNames)];
                        $last = $this->lastNames[$studentIndex % count($this->lastNames)];
                        $email = sprintf('%s.student.%d@example.com', $slug, $studentIndex);

                        if ($studentIndex === 1) {
                            $email = $slug . '.student@example.com';
                        }

                        $user = $this->createUserAccount([
                            'name'      => $first . ' ' . $last,
                            'email'     => $email,
                            'phone'     => '+92 300 5' . str_pad((string) ($branchId * 1000 + $studentIndex), 6, '0', STR_PAD_LEFT),
                            'role_id'   => RoleEnum::STUDENT,
                            'branch_id' => $branchId,
                        ]);

                        if ($studentIndex === 1) {
                            if ($isBoys) {
                                self::$boysStudentUserId = $user->id;
                            } else {
                                self::$girlsStudentUserId = $user->id;
                            }
                        }

                        $student = Student::create([
                            'user_id'             => $user->id,
                            'admission_no'        => strtoupper($slug) . '-2025-' . str_pad((string) $studentIndex, 4, '0', STR_PAD_LEFT),
                            'roll_no'             => $studentIndex,
                            'first_name'          => $first,
                            'last_name'           => $last,
                            'mobile'              => $user->phone,
                            'email'               => $email,
                            'dob'                 => '2010-06-15',
                            'admission_date'      => now()->subMonths(3)->format('Y-m-d'),
                            'religion_id'         => 1,
                            'department_id'       => DemoOrganizationSeeder::$departmentsByBranch[$branchId]['Mathematics'],
                            'blood_group_id'      => 1,
                            'gender_id'           => $isBoys ? 1 : 2,
                            'parent_guardian_id'  => $parents[array_rand($parents)],
                            'student_category_id' => DemoAcademicSeeder::$studentCategoryByBranch[$branchId],
                            'status'              => 1,
                            'branch_id'           => $branchId,
                            'upload_documents'    => [],
                        ]);

                        SessionClassStudent::create([
                            'session_id'  => $sessionId,
                            'student_id'  => $student->id,
                            'classes_id'  => $classId,
                            'section_id'  => $sectionId,
                            'shift_id'    => DemoAcademicSeeder::$shiftByBranch[$branchId],
                            'roll'        => $studentIndex,
                            'branch_id'   => $branchId,
                        ]);

                        self::$studentCount++;
                        $studentIndex++;
                    }
                }
            }
        }
    }

    private function seedParents(int $branchId, string $slug, int $count): array
    {
        $ids = [];

        for ($i = 1; $i <= $count; $i++) {
            $email = $slug . '.guardian' . $i . '@example.com';
            $user = $this->createUserAccount([
                'name'      => 'Guardian ' . $i . ' (' . $slug . ')',
                'email'     => $email,
                'phone'     => '+92 301' . str_pad((string) ($branchId * 100 + $i), 7, '0', STR_PAD_LEFT),
                'role_id'   => RoleEnum::GUARDIAN,
                'branch_id' => $branchId,
            ]);

            $parent = ParentGuardian::create([
                'user_id'           => $user->id,
                'father_name'       => 'Muhammad Guardian ' . $i,
                'father_mobile'     => $user->phone,
                'father_profession' => 'Business',
                'mother_name'       => 'Sara Guardian',
                'mother_mobile'     => $user->phone,
                'mother_profession' => 'Homemaker',
                'guardian_name'     => $user->name,
                'guardian_email'    => $email,
                'guardian_mobile'   => $user->phone,
                'guardian_profession' => 'Business',
                'guardian_relation' => 'Father',
                'guardian_address'  => 'Peshawar, Pakistan',
                'branch_id'         => $branchId,
            ]);

            $ids[] = $parent->id;
        }

        return $ids;
    }

    /** @return array<string, int> designation => user_id */
    private function seedStaff(int $branchId, string $slug, bool $isBoys): array
    {
        $roles = [
            'Principal'      => RoleEnum::STAFF,
            'Vice Principal' => RoleEnum::STAFF,
            'Teacher'        => RoleEnum::TEACHER,
            'Senior Teacher' => RoleEnum::TEACHER,
            'Junior Teacher' => RoleEnum::TEACHER,
            'Accountant'     => RoleEnum::ACCOUNTING,
            'Clerk'          => RoleEnum::STAFF,
            'Lab Assistant'  => RoleEnum::STAFF,
        ];

        $map = [];
        $n = 1;

        foreach ($roles as $designationName => $roleId) {
            $email = strtolower(str_replace(' ', '.', $designationName)) . '.' . $slug . '@example.com';

            if ($designationName === 'Teacher') {
                $email = $slug . '.teacher@example.com';
            }

            $user = $this->createUserAccount([
                'name'      => $designationName . ' (' . ($isBoys ? 'Boys' : 'Girls') . ')',
                'email'     => $email,
                'phone'     => '+92 302' . str_pad((string) ($branchId * 100 + $n), 7, '0', STR_PAD_LEFT),
                'role_id'   => $roleId,
                'branch_id' => $branchId,
            ]);

            $deptName = match ($designationName) {
                'Accountant', 'Clerk' => 'Mathematics',
                'Lab Assistant' => 'Science',
                default => 'English',
            };

            Staff::create([
                'user_id'           => $user->id,
                'staff_id'          => ($branchId * 1000) + $n,
                'role_id'           => $roleId,
                'designation_id'    => DemoOrganizationSeeder::$designationsByBranch[$branchId][$designationName],
                'department_id'     => DemoOrganizationSeeder::$departmentsByBranch[$branchId][$deptName],
                'first_name'        => $designationName,
                'last_name'         => $isBoys ? 'Boys' : 'Girls',
                'email'             => $email,
                'gender_id'         => $isBoys ? 1 : 2,
                'dob'               => '1985-01-01',
                'joining_date'      => '2020-01-01',
                'phone'             => $user->phone,
                'status'            => 1,
                'branch_id'         => $branchId,
                'upload_documents'  => [],
            ]);

            $map[$designationName] = $user->id;
            self::$staffCount++;
            $n++;
        }

        return $map;
    }

    private function createUserAccount(array $data): User
    {
        $user = new User();
        $user->name              = $data['name'];
        $user->email             = $data['email'];
        $user->phone             = $data['phone'];
        $user->email_verified_at = now();
        $user->password          = Hash::make(DemoContext::PASSWORD);
        $user->role_id           = $data['role_id'];
        $user->branch_id         = $data['branch_id'];
        $user->permissions       = [];
        $user->uuid              = Str::uuid();
        $user->save();

        return $user;
    }
}
