<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Enums\SubjectType;
use App\Models\Academic\ClassSetup;
use App\Models\Academic\ClassSetupChildren;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Session;
use App\Models\Setting;
use App\Models\Staff\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Dream Tuition Academy — classes, sections, class setup, subjects, departments.
 *
 * php artisan db:seed --class=DreamTuitionAcademySeeder --force
 */
class DreamTuitionAcademySeeder extends Seeder
{
    private const SHARED_BRANCH = 0;

    /** @var array<string, int> */
    private array $sections = [];

    /** @var array<string, int> */
    private array $classes = [];

    public function run(): void
    {
        $sessionId = $this->seedSession();
        $this->seedDepartments();
        $this->seedSections();
        $this->seedClasses();
        $this->seedClassSetups($sessionId);
        $this->seedSubjects();

        $this->command?->info('Dream Tuition Academy structure seeded.');
        $this->command?->line("Active session id: {$sessionId}");
        $this->command?->line('Classes: ' . count($this->classes) . ', Sections: ' . count($this->sections));
    }

    private function seedSession(): int
    {
        $session = Session::withoutGlobalScopes()->updateOrCreate(
            ['name' => '2026'],
            [
                'start_date' => '2026-01-01',
                'end_date'   => '2026-12-31',
                'status'     => Status::ACTIVE,
                'branch_id'  => self::SHARED_BRANCH,
            ]
        );

        if (Schema::hasTable('settings')) {
            $branchIds = DB::table('branches')->pluck('id')->all();
            if ($branchIds === []) {
                $branchIds = [1];
            }
            foreach ($branchIds as $branchId) {
                Setting::query()->updateOrCreate(
                    ['name' => 'session', 'branch_id' => (int) $branchId],
                    ['value' => (string) $session->id]
                );
            }
        }

        return (int) $session->id;
    }

    private function seedDepartments(): void
    {
        foreach ([
            'IT & Diploma Programs',
            'Languages',
            'Creative Courses',
            'School Tuition',
        ] as $name) {
            Department::withoutGlobalScopes()->updateOrCreate(
                ['name' => $name, 'branch_id' => self::SHARED_BRANCH],
                ['status' => Status::ACTIVE]
            );
        }
    }

    private function seedSections(): void
    {
        $names = [
            'General',
            'Semester 1 (6 Months)',
            'Semester 2 (6 Months)',
            'Active Zero',
            'Active 1',
            'Active 2',
            'Active 3',
            'Level 1',
            'Level 2',
            'Level 3',
            'Level 4',
            'Special Grammar Class',
            '3 Months Course',
        ];

        foreach ($names as $name) {
            $row = Section::withoutGlobalScopes()->updateOrCreate(
                ['name' => $name],
                ['status' => Status::ACTIVE, 'branch_id' => self::SHARED_BRANCH]
            );
            $this->sections[$name] = (int) $row->id;
        }
    }

    private function seedClasses(): void
    {
        $names = [
            'DIT',
            'CIT',
            'English Language',
            'Graphic Designing',
            'Calligraphy',
            'PG',
            'Nursery',
            'Prep',
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4',
            'Class 5',
            'Class 6',
            'Class 7',
            'Class 8',
            'Class 9',
            'Class 10',
            'Class 11',
            'Class 12',
        ];

        foreach ($names as $name) {
            $row = Classes::withoutGlobalScopes()->updateOrCreate(
                ['name' => $name],
                ['status' => Status::ACTIVE, 'branch_id' => self::SHARED_BRANCH]
            );
            $this->classes[$name] = (int) $row->id;
        }
    }

    private function seedClassSetups(int $sessionId): void
    {
        $map = [
            'DIT' => ['Semester 1 (6 Months)', 'Semester 2 (6 Months)'],
            'CIT' => ['Semester 1 (6 Months)'],
            'English Language' => [
                'Active Zero', 'Active 1', 'Active 2', 'Active 3',
                'Level 1', 'Level 2', 'Level 3', 'Level 4', 'Special Grammar Class',
            ],
            'Graphic Designing' => ['3 Months Course'],
            'Calligraphy' => ['3 Months Course'],
        ];

        foreach (['PG', 'Nursery', 'Prep', 'Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5', 'Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10', 'Class 11', 'Class 12'] as $className) {
            $map[$className] = ['General'];
        }

        foreach ($map as $className => $sectionNames) {
            if (! isset($this->classes[$className])) {
                continue;
            }

            $setup = ClassSetup::withoutGlobalScopes()->updateOrCreate(
                [
                    'session_id' => $sessionId,
                    'classes_id' => $this->classes[$className],
                ],
                [
                    'status'    => Status::ACTIVE,
                    'branch_id' => self::SHARED_BRANCH,
                ]
            );

            ClassSetupChildren::withoutGlobalScopes()
                ->where('class_setup_id', $setup->id)
                ->delete();

            foreach ($sectionNames as $sectionName) {
                if (! isset($this->sections[$sectionName])) {
                    continue;
                }
                ClassSetupChildren::create([
                    'class_setup_id' => $setup->id,
                    'section_id'     => $this->sections[$sectionName],
                    'status'         => Status::ACTIVE,
                    'branch_id'      => self::SHARED_BRANCH,
                ]);
            }
        }
    }

    private function seedSubjects(): void
    {
        $theory = SubjectType::THEORY;
        $practical = SubjectType::PRACTICAL;

        $subjects = [
            ['English', 'ENG', $theory],
            ['Urdu', 'URD', $theory],
            ['Mathematics', 'MATH', $theory],
            ['Islamiat', 'ISL', $theory],
            ['General Knowledge', 'GK', $theory],
            ['Science', 'SCI', $theory],
            ['Biology', 'BIO', $theory],
            ['Chemistry', 'CHEM', $theory],
            ['Physics', 'PHY', $theory],
            ['Computer Science', 'CS', $theory],
            ['Speaking', 'SPK', $theory],
            ['Writing', 'WRT', $theory],
            ['Grammar', 'GRM', $theory],
            ['Listening', 'LST', $theory],
            ['Computer Fundamentals', 'CF', $theory],
            ['Programming', 'PROG', $theory],
            ['Networking', 'NET', $theory],
            ['Graphic Design Practical', 'GDP', $practical],
            ['Typography', 'TYP', $theory],
            ['Calligraphy Basics', 'CAL', $practical],
        ];

        $codeUsed = [];
        foreach ($subjects as [$name, $code, $type]) {
            $uniqueCode = $code;
            $n = 1;
            while (isset($codeUsed[$uniqueCode])) {
                $uniqueCode = $code . $n++;
            }
            $codeUsed[$uniqueCode] = true;

            Subject::withoutGlobalScopes()->updateOrCreate(
                ['name' => $name],
                [
                    'code'      => $uniqueCode,
                    'type'      => $type,
                    'status'    => Status::ACTIVE,
                    'branch_id' => self::SHARED_BRANCH,
                ]
            );
        }
    }
}
