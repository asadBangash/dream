<?php

namespace Database\Seeders;

use App\Enums\FineType;
use App\Enums\Status;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Fees\FeesAssign;
use App\Models\Fees\FeesAssignChildren;
use App\Models\Fees\FeesGroup;
use App\Models\Fees\FeesMaster;
use App\Models\Fees\FeesType;
use App\Models\Role;
use App\Models\Session;
use App\Models\User;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Sample fee groups, types, masters (session 2026), and assigns for enrolled students.
 *
 * php artisan academy:seed-fees
 */
class DreamTuitionFeesSeeder extends Seeder
{
    /** @var array<string, int> */
    private array $groups = [];

    /** @var array<string, int> */
    private array $types = [];

    /** @var array<string, int> */
    private array $classes = [];

    /** @var array<string, int> */
    private array $sections = [];

    private int $sessionId;

    public function run(): void
    {
        $session = Session::withoutGlobalScopes()->where('name', '2026')->first();
        if (! $session) {
            $this->command?->error('Session "2026" not found. Run: php artisan academy:seed-dream');

            return;
        }
        $this->sessionId = (int) $session->id;

        $this->loadClassSectionMaps();
        $this->seedDemoStudentsIfNeeded();
        $this->seedGroups();
        $this->seedTypes();
        $masterIdsByGroup = $this->seedMasters();
        $assigned = $this->seedAssigns($masterIdsByGroup);

        $this->command?->info('Dream Tuition fees seeded for session 2026.');
        $this->command?->line('Groups: ' . count($this->groups) . ', Types: ' . count($this->types));
        $this->command?->line('Fee lines (masters): ' . array_sum(array_map('count', $masterIdsByGroup)));
        $this->command?->line('Assign rows (students × fee lines): ' . $assigned);
        $this->command?->line('No payments collected — use Fees → Collect to test.');
    }

    private function seedDemoStudentsIfNeeded(): void
    {
        $hasEnrollment = SessionClassStudent::withoutGlobalScopes()
            ->where('session_id', $this->sessionId)
            ->exists();
        if ($hasEnrollment) {
            return;
        }

        $branchId = (int) (DB::table('branches')->orderBy('id')->value('id') ?? 1);
        $genderId = (int) (DB::table('genders')->orderBy('id')->value('id') ?? 1);
        $religionId = DB::table('religions')->orderBy('id')->value('id');
        $departmentId = DB::table('departments')->orderBy('id')->value('id');

        $parent = ParentGuardian::withoutGlobalScopes()->where('guardian_email', 'farman.ullah@dream.test')->first();
        if (! $parent) {
            $role = Role::find(7);
            $guardianUser = User::query()->create([
                'name'              => 'farman ullah',
                'email'             => 'farman.ullah@dream.test',
                'phone'             => '03001234567',
                'password'          => Hash::make('123456'),
                'email_verified_at' => now(),
                'role_id'           => $role?->id ?? 7,
                'permissions'       => $role?->permissions ?? [],
                'uuid'              => (string) Str::uuid(),
                'branch_id'         => $branchId,
            ]);
            $parent = ParentGuardian::withoutGlobalScopes()->create([
                'user_id'           => $guardianUser->id,
                'guardian_name'     => 'farman ullah',
                'guardian_email'    => 'farman.ullah@dream.test',
                'guardian_mobile'   => '03001234567',
                'guardian_relation' => 'father',
                'status'            => Status::ACTIVE,
                'branch_id'         => $branchId,
            ]);
        }

        $ditClass = $this->classes['DIT'] ?? null;
        $ditSection = $this->sections['Semester 1 (6 Months)'] ?? null;
        if ($ditClass && $ditSection) {
            $student = Student::withoutGlobalScopes()->firstOrCreate(
                ['admission_no' => '03237312563'],
                [
                    'first_name'         => 'Gohar',
                    'last_name'          => 'Rahman',
                    'mobile'             => '',
                    'email'              => 'gohar.rahman.student@dream.test',
                    'dob'                => '2005-06-15',
                    'admission_date'     => '2026-01-10',
                    'gender_id'          => $genderId,
                    'religion_id'        => $religionId,
                    'department_id'      => $departmentId,
                    'parent_guardian_id' => $parent->id,
                    'status'             => Status::ACTIVE,
                    'branch_id'          => $branchId,
                    'roll_no'            => 1,
                ]
            );

            SessionClassStudent::withoutGlobalScopes()->firstOrCreate(
                [
                    'session_id' => $this->sessionId,
                    'student_id' => $student->id,
                    'classes_id' => $ditClass,
                    'section_id' => $ditSection,
                ],
                [
                    'roll'       => '1',
                    'branch_id'  => $branchId,
                ]
            );
        }

        $class8 = $this->classes['Class 8'] ?? null;
        $general = $this->sections['General'] ?? null;
        if ($class8 && $general) {
            $student2 = Student::withoutGlobalScopes()->firstOrCreate(
                ['admission_no' => 'DTA-2026-0008'],
                [
                    'first_name'         => 'Ali',
                    'last_name'          => 'Khan',
                    'mobile'             => '03009876543',
                    'email'              => 'ali.khan.student@dream.test',
                    'dob'                => '2012-03-20',
                    'admission_date'     => '2026-01-15',
                    'gender_id'          => $genderId,
                    'religion_id'        => $religionId,
                    'department_id'      => $departmentId,
                    'parent_guardian_id' => $parent->id,
                    'status'             => Status::ACTIVE,
                    'branch_id'          => $branchId,
                    'roll_no'            => 8,
                ]
            );

            SessionClassStudent::withoutGlobalScopes()->firstOrCreate(
                [
                    'session_id' => $this->sessionId,
                    'student_id' => $student2->id,
                    'classes_id' => $class8,
                    'section_id' => $general,
                ],
                [
                    'roll'      => '8',
                    'branch_id' => $branchId,
                ]
            );
        }

        $this->command?->warn('No enrollments found — created demo students (Gohar Rahman / DIT, Ali Khan / Class 8).');
    }

    private function loadClassSectionMaps(): void
    {
        Classes::withoutGlobalScopes()->get(['id', 'name'])->each(function ($row) {
            $this->classes[$row->name] = (int) $row->id;
        });
        Section::withoutGlobalScopes()->get(['id', 'name'])->each(function ($row) {
            $this->sections[$row->name] = (int) $row->id;
        });
    }

    private function seedGroups(): void
    {
        $definitions = [
            ['name' => 'DIT Semester 1', 'description' => 'DIT first semester fee package'],
            ['name' => 'DIT Semester 2', 'description' => 'DIT second semester fee package'],
            ['name' => 'CIT Semester 1', 'description' => 'CIT first semester fee package'],
            ['name' => 'English Language', 'description' => 'English course fees'],
            ['name' => 'School Tuition Monthly', 'description' => 'PG–Class 12 monthly tuition'],
            ['name' => 'Short Courses', 'description' => 'Graphic design, calligraphy, etc.'],
            ['name' => 'Misc & One-time', 'description' => 'ID card, certificate, misc charges'],
        ];

        foreach ($definitions as $def) {
            $row = FeesGroup::query()->updateOrCreate(
                ['name' => $def['name']],
                [
                    'description'           => $def['description'],
                    'status'                => Status::ACTIVE,
                    'online_admission_fees' => 0,
                ]
            );
            $this->groups[$def['name']] = (int) $row->id;
        }
    }

    private function seedTypes(): void
    {
        $definitions = [
            ['name' => 'Admission Fee', 'code' => 'ADM'],
            ['name' => 'Registration Fee', 'code' => 'REG'],
            ['name' => 'Semester Tuition', 'code' => 'SEM-TUI'],
            ['name' => 'Monthly Tuition', 'code' => 'MON-TUI'],
            ['name' => 'Exam Fee', 'code' => 'EXM'],
            ['name' => 'Lab / Practical Fee', 'code' => 'LAB'],
            ['name' => 'Library Fee', 'code' => 'LIB'],
            ['name' => 'ID Card Fee', 'code' => 'ID'],
            ['name' => 'Certificate Fee', 'code' => 'CERT'],
            ['name' => 'Course Material Fee', 'code' => 'MAT'],
            ['name' => 'Late Fine (sample)', 'code' => 'LATE'],
        ];

        foreach ($definitions as $def) {
            $row = FeesType::query()->updateOrCreate(
                ['code' => $def['code']],
                [
                    'name'        => $def['name'],
                    'description' => $def['name'] . ' for Dream Tuition Academy',
                    'status'      => Status::ACTIVE,
                ]
            );
            $this->types[$def['code']] = (int) $row->id;
        }
    }

    /**
     * @return array<string, list<int>>
     */
    private function seedMasters(): array
    {
        $plans = [
            'DIT Semester 1' => [
                ['type' => 'ADM', 'amount' => 2500, 'due' => '2026-02-15', 'fine_type' => FineType::NONE],
                ['type' => 'SEM-TUI', 'amount' => 18500, 'due' => '2026-03-01', 'fine_type' => FineType::PERCENTAGE, 'percentage' => 5],
                ['type' => 'LAB', 'amount' => 3500, 'due' => '2026-03-01', 'fine_type' => FineType::NONE],
                ['type' => 'EXM', 'amount' => 2000, 'due' => '2026-06-01', 'fine_type' => FineType::FIX_AMOUNT, 'fine_amount' => 500],
            ],
            'DIT Semester 2' => [
                ['type' => 'SEM-TUI', 'amount' => 19200, 'due' => '2026-08-01', 'fine_type' => FineType::PERCENTAGE, 'percentage' => 5],
                ['type' => 'LAB', 'amount' => 3500, 'due' => '2026-08-01', 'fine_type' => FineType::NONE],
                ['type' => 'EXM', 'amount' => 2200, 'due' => '2026-11-15', 'fine_type' => FineType::NONE],
            ],
            'CIT Semester 1' => [
                ['type' => 'ADM', 'amount' => 2000, 'due' => '2026-02-10', 'fine_type' => FineType::NONE],
                ['type' => 'SEM-TUI', 'amount' => 15000, 'due' => '2026-03-05', 'fine_type' => FineType::PERCENTAGE, 'percentage' => 3],
                ['type' => 'MAT', 'amount' => 1200, 'due' => '2026-03-05', 'fine_type' => FineType::NONE],
            ],
            'English Language' => [
                ['type' => 'REG', 'amount' => 1500, 'due' => '2026-01-20', 'fine_type' => FineType::NONE],
                ['type' => 'MON-TUI', 'amount' => 4500, 'due' => '2026-02-05', 'fine_type' => FineType::FIX_AMOUNT, 'fine_amount' => 200],
                ['type' => 'MON-TUI', 'amount' => 4500, 'due' => '2026-03-05', 'fine_type' => FineType::FIX_AMOUNT, 'fine_amount' => 200],
            ],
            'School Tuition Monthly' => [
                ['type' => 'ADM', 'amount' => 3000, 'due' => '2026-01-15', 'fine_type' => FineType::NONE],
                ['type' => 'MON-TUI', 'amount' => 5500, 'due' => '2026-02-01', 'fine_type' => FineType::PERCENTAGE, 'percentage' => 2],
                ['type' => 'MON-TUI', 'amount' => 5500, 'due' => '2026-03-01', 'fine_type' => FineType::PERCENTAGE, 'percentage' => 2],
                ['type' => 'EXM', 'amount' => 1800, 'due' => '2026-04-10', 'fine_type' => FineType::NONE],
            ],
            'Short Courses' => [
                ['type' => 'REG', 'amount' => 1000, 'due' => '2026-02-01', 'fine_type' => FineType::NONE],
                ['type' => 'SEM-TUI', 'amount' => 12000, 'due' => '2026-02-15', 'fine_type' => FineType::NONE],
                ['type' => 'MAT', 'amount' => 2500, 'due' => '2026-02-15', 'fine_type' => FineType::NONE],
            ],
            'Misc & One-time' => [
                ['type' => 'ID', 'amount' => 350, 'due' => '2026-01-31', 'fine_type' => FineType::NONE],
                ['type' => 'LIB', 'amount' => 500, 'due' => '2026-02-28', 'fine_type' => FineType::NONE],
                ['type' => 'CERT', 'amount' => 750, 'due' => '2026-12-01', 'fine_type' => FineType::NONE],
                ['type' => 'LATE', 'amount' => 100, 'due' => '2026-03-01', 'fine_type' => FineType::FIX_AMOUNT, 'fine_amount' => 100],
            ],
        ];

        // English group: two monthly lines need distinct types — use extra type rows for 2nd month
        $this->ensureExtraMonthlyType();

        $masterIdsByGroup = [];

        foreach ($plans as $groupName => $lines) {
            if (! isset($this->groups[$groupName])) {
                continue;
            }
            $groupId = $this->groups[$groupName];
            $masterIdsByGroup[$groupName] = [];

            foreach ($lines as $index => $line) {
                $typeCode = $line['type'];
                $typeId = $this->resolveTypeId($groupName, $typeCode, $index);

                $master = FeesMaster::query()->updateOrCreate(
                    [
                        'session_id'    => $this->sessionId,
                        'fees_group_id' => $groupId,
                        'fees_type_id'  => $typeId,
                    ],
                    [
                        'due_date'     => $line['due'],
                        'amount'       => $line['amount'],
                        'fine_type'    => $line['fine_type'],
                        'percentage'   => $line['percentage'] ?? 0,
                        'fine_amount'  => $line['fine_amount'] ?? 0,
                        'status'       => Status::ACTIVE,
                    ]
                );
                $masterIdsByGroup[$groupName][] = (int) $master->id;
            }
        }

        return $masterIdsByGroup;
    }

    private function ensureExtraMonthlyType(): void
    {
        $row = FeesType::query()->updateOrCreate(
            ['code' => 'MON-TUI-2'],
            [
                'name'        => 'Monthly Tuition (2nd month)',
                'description' => 'Second monthly tuition line for seed data',
                'status'      => Status::ACTIVE,
            ]
        );
        $this->types['MON-TUI-2'] = (int) $row->id;
    }

    private function resolveTypeId(string $groupName, string $typeCode, int $lineIndex): int
    {
        if ($groupName === 'English Language' && $typeCode === 'MON-TUI' && $lineIndex === 2) {
            return $this->types['MON-TUI-2'];
        }
        if ($groupName === 'School Tuition Monthly' && $typeCode === 'MON-TUI' && $lineIndex === 2) {
            return $this->types['MON-TUI-2'];
        }

        return $this->types[$typeCode];
    }

    /**
     * @param  array<string, list<int>>  $masterIdsByGroup
     */
    private function seedAssigns(array $masterIdsByGroup): int
    {
        $rules = [
            ['group' => 'DIT Semester 1', 'class' => 'DIT', 'section' => 'Semester 1 (6 Months)'],
            ['group' => 'DIT Semester 2', 'class' => 'DIT', 'section' => 'Semester 2 (6 Months)'],
            ['group' => 'CIT Semester 1', 'class' => 'CIT', 'section' => 'Semester 1 (6 Months)'],
            ['group' => 'English Language', 'class' => 'English Language', 'section' => null],
            ['group' => 'Short Courses', 'class' => 'Graphic Designing', 'section' => '3 Months Course'],
            ['group' => 'Short Courses', 'class' => 'Calligraphy', 'section' => '3 Months Course'],
        ];

        $schoolClassNames = [
            'PG', 'Nursery', 'Prep', 'Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5',
            'Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10', 'Class 11', 'Class 12',
        ];
        foreach ($schoolClassNames as $className) {
            $rules[] = ['group' => 'School Tuition Monthly', 'class' => $className, 'section' => 'General'];
        }

        // Misc fees for anyone in DIT Semester 1 (extra random charges)
        $miscGroup = 'Misc & One-time';

        $childCount = 0;

        DB::transaction(function () use ($rules, $masterIdsByGroup, $miscGroup, &$childCount) {
            foreach ($rules as $rule) {
                $groupName = $rule['group'];
                if (! isset($masterIdsByGroup[$groupName], $this->groups[$groupName])) {
                    continue;
                }
                $classId = $this->classes[$rule['class']] ?? null;
                if (! $classId) {
                    continue;
                }
                $sectionId = $rule['section'] !== null
                    ? ($this->sections[$rule['section']] ?? null)
                    : null;

                if ($sectionId === null) {
                    $buckets = $this->enrolledStudentsBySection($classId);
                    foreach ($buckets as $bucketSectionId => $studentIds) {
                        if ($studentIds === []) {
                            continue;
                        }
                        $childCount += $this->assignGroupToStudents(
                            $this->groups[$groupName],
                            $masterIdsByGroup[$groupName],
                            $classId,
                            $bucketSectionId,
                            $studentIds
                        );
                    }
                    continue;
                }

                $students = $this->enrolledStudentIds($classId, $sectionId);
                if ($students['student_ids'] === []) {
                    continue;
                }

                $childCount += $this->assignGroupToStudents(
                    $this->groups[$groupName],
                    $masterIdsByGroup[$groupName],
                    $classId,
                    $sectionId,
                    $students['student_ids']
                );
            }

            // Attach misc package to all DIT Semester 1 students (if any)
            if (isset($masterIdsByGroup[$miscGroup], $this->groups[$miscGroup])) {
                $ditClass = $this->classes['DIT'] ?? null;
                $sem1 = $this->sections['Semester 1 (6 Months)'] ?? null;
                if ($ditClass && $sem1) {
                    $students = $this->enrolledStudentIds($ditClass, $sem1);
                    if ($students['student_ids'] !== []) {
                        $childCount += $this->assignGroupToStudents(
                            $this->groups[$miscGroup],
                            $masterIdsByGroup[$miscGroup],
                            $ditClass,
                            $sem1,
                            $students['student_ids']
                        );
                    }
                }
            }
        });

        return $childCount;
    }

    /**
     * @return array<int, list<int>>
     */
    private function enrolledStudentsBySection(int $classId): array
    {
        $rows = SessionClassStudent::withoutGlobalScopes()
            ->where('session_id', $this->sessionId)
            ->where('classes_id', $classId)
            ->get(['student_id', 'section_id']);

        $buckets = [];
        foreach ($rows as $row) {
            $sid = (int) $row->section_id;
            if ($sid < 1) {
                continue;
            }
            $buckets[$sid] ??= [];
            $buckets[$sid][] = (int) $row->student_id;
        }

        foreach ($buckets as $sid => $ids) {
            $buckets[$sid] = array_values(array_unique($ids));
        }

        return $buckets;
    }

    /**
     * @return array{student_ids: list<int>, section_id: int|null}
     */
    private function enrolledStudentIds(int $classId, ?int $sectionId): array
    {
        $query = SessionClassStudent::withoutGlobalScopes()
            ->where('session_id', $this->sessionId)
            ->where('classes_id', $classId);

        if ($sectionId !== null) {
            $query->where('section_id', $sectionId);
        }

        $rows = $query->get(['student_id', 'section_id']);
        if ($rows->isEmpty()) {
            return ['student_ids' => [], 'section_id' => $sectionId];
        }

        $resolvedSection = $sectionId ?? (int) $rows->first()->section_id;

        return [
            'student_ids' => $rows->pluck('student_id')->unique()->values()->all(),
            'section_id'  => $resolvedSection,
        ];
    }

    /**
     * @param  list<int>  $masterIds
     * @param  list<int>  $studentIds
     */
    private function assignGroupToStudents(
        int $feesGroupId,
        array $masterIds,
        int $classId,
        int $sectionId,
        array $studentIds
    ): int {
        $assign = FeesAssign::query()->firstOrCreate(
            [
                'session_id'    => $this->sessionId,
                'classes_id'    => $classId,
                'section_id'    => $sectionId,
                'fees_group_id' => $feesGroupId,
            ],
            [
                'category_id' => null,
                'gender_id'   => null,
            ]
        );

        $created = 0;
        foreach ($masterIds as $masterId) {
            foreach ($studentIds as $studentId) {
                $exists = FeesAssignChildren::query()
                    ->where('fees_master_id', $masterId)
                    ->where('student_id', $studentId)
                    ->exists();
                if ($exists) {
                    continue;
                }
                FeesAssignChildren::query()->create([
                    'fees_assign_id'  => $assign->id,
                    'fees_master_id'  => $masterId,
                    'student_id'      => $studentId,
                ]);
                $created++;
            }
        }

        return $created;
    }
}
