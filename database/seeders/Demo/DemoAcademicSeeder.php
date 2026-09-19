<?php

namespace Database\Seeders\Demo;

use App\Models\Academic\ClassSetup;
use App\Models\Academic\ClassSetupChildren;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Shift;
use App\Models\Academic\Subject;
use App\Models\StudentInfo\StudentCategory;
use Illuminate\Database\Seeder;

class DemoAcademicSeeder extends Seeder
{
    /** @var array<int, array<int, int>> branch => [className => classId] */
    public static array $classesByBranch = [];

    /** @var array<int, array<string, int>> branch => [sectionName => sectionId] */
    public static array $sectionsByBranch = [];

    /** @var array<int, array<string, int>> branch => [subjectName => subjectId] */
    public static array $subjectsByBranch = [];

    public static array $shiftByBranch = [];

    public static array $studentCategoryByBranch = [];

    private array $classNames = ['6', '7', '8', '9', '10', '11', '12'];

    private array $sectionNames = ['A', 'B', 'C'];

    private array $subjectNames = [
        'English',
        'Mathematics',
        'Urdu',
        'Science',
        'Islamic Studies',
        'Computer Science',
    ];

    public function run(): void
    {
        $sessionId = (int) setting('session');

        foreach (DemoContext::branches() as $branchId => $branchName) {
            $regular = StudentCategory::create(['name' => 'Regular', 'branch_id' => $branchId]);
            StudentCategory::create(['name' => 'Scholarship', 'branch_id' => $branchId]);
            self::$studentCategoryByBranch[$branchId] = $regular->id;

            $shift = Shift::create([
                'name'      => 'Morning',
                'branch_id' => $branchId,
            ]);
            self::$shiftByBranch[$branchId] = $shift->id;

            foreach ($this->sectionNames as $sectionName) {
                $section = Section::create([
                    'name'      => $sectionName,
                    'branch_id' => $branchId,
                ]);
                self::$sectionsByBranch[$branchId][$sectionName] = $section->id;
            }

            foreach ($this->classNames as $className) {
                $class = Classes::create([
                    'name'      => 'Class ' . $className,
                    'branch_id' => $branchId,
                ]);
                self::$classesByBranch[$branchId][$className] = $class->id;

                $setup = ClassSetup::create([
                    'session_id' => $sessionId,
                    'classes_id' => $class->id,
                    'branch_id'  => $branchId,
                ]);

                foreach (self::$sectionsByBranch[$branchId] as $sectionId) {
                    ClassSetupChildren::create([
                        'class_setup_id' => $setup->id,
                        'section_id'     => $sectionId,
                        'branch_id'      => $branchId,
                    ]);
                }
            }

            foreach ($this->subjectNames as $subjectName) {
                $subject = Subject::create([
                    'name'      => $subjectName,
                    'code'      => strtoupper(substr($subjectName, 0, 3)) . $branchId,
                    'branch_id' => $branchId,
                ]);
                self::$subjectsByBranch[$branchId][$subjectName] = $subject->id;
            }
        }
    }
}
