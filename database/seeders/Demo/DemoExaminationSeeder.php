<?php

namespace Database\Seeders\Demo;

use App\Models\Academic\Classes;
use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\ExamAssignChildren;
use App\Models\Examination\ExamType;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Models\Examination\MarksRegisterChildren;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Database\Seeder;

class DemoExaminationSeeder extends Seeder
{
    public static int $examTypeCount = 0;

    public static int $marksRegisterCount = 0;

    private array $examNames = [
        'Mid Term Examination',
        'Final Examination',
        'Monthly Test',
        'Annual Examination',
    ];

    public function run(): void
    {
        $sessionId = (int) setting('session');

        foreach (DemoContext::branches() as $branchId => $branchName) {
            $examTypeIds = [];

            foreach ($this->examNames as $examName) {
                $exam = ExamType::create([
                    'name'      => $examName,
                    'branch_id' => $branchId,
                ]);
                $examTypeIds[] = $exam->id;
                self::$examTypeCount++;
            }

            foreach (['A+', 'A', 'B', 'C', 'F'] as $index => $grade) {
                MarksGrade::create([
                    'name'         => $grade,
                    'percent_from' => max(0, 90 - ($index * 15)),
                    'percent_upto' => 100 - ($index * 15),
                    'point'        => max(1, 5 - $index),
                    'remarks'      => $grade,
                    'session_id'   => $sessionId,
                    'branch_id'    => $branchId,
                ]);
            }

            $classId = DemoAcademicSeeder::$classesByBranch[$branchId]['9'];
            $sectionId = DemoAcademicSeeder::$sectionsByBranch[$branchId]['A'];
            $class = Classes::find($classId);

            $teacherStaffIds = Staff::withoutGlobalScopes()
                ->where('branch_id', $branchId)
                ->whereIn('role_id', [5])
                ->pluck('id')
                ->all();

            $subjectAssign = SubjectAssign::create([
                'session_id' => $sessionId,
                'classes_id' => $classId,
                'section_id' => $sectionId,
                'status'     => 1,
                'branch_id'  => $branchId,
            ]);

            $subjectIds = array_slice(array_values(DemoAcademicSeeder::$subjectsByBranch[$branchId]), 0, 4);

            foreach ($subjectIds as $subjectId) {
                SubjectAssignChildren::create([
                    'subject_assign_id' => $subjectAssign->id,
                    'subject_id'        => $subjectId,
                    'staff_id'          => $teacherStaffIds[array_rand($teacherStaffIds)] ?? $teacherStaffIds[0],
                    'status'            => 1,
                    'branch_id'         => $branchId,
                ]);
            }

            $midTermId = $examTypeIds[0];

            foreach ($subjectIds as $subjectId) {
                $examAssign = ExamAssign::create([
                    'session_id'   => $sessionId,
                    'classes_id'   => $classId,
                    'section_id'   => $sectionId,
                    'exam_type_id' => $midTermId,
                    'subject_id'   => $subjectId,
                    'total_mark'   => 100,
                    'branch_id'    => $branchId,
                ]);

                ExamAssignChildren::create([
                    'exam_assign_id' => $examAssign->id,
                    'title'          => 'Written',
                    'mark'           => 100,
                    'branch_id'      => $branchId,
                ]);

                $markRegister = MarksRegister::create([
                    'session_id'   => $sessionId,
                    'classes_id'   => $classId,
                    'section_id'   => $sectionId,
                    'exam_type_id' => $midTermId,
                    'subject_id'   => $subjectId,
                    'branch_id'    => $branchId,
                ]);

                $students = SessionClassStudent::withoutGlobalScopes()
                    ->where('branch_id', $branchId)
                    ->where('classes_id', $classId)
                    ->where('section_id', $sectionId)
                    ->where('session_id', $sessionId)
                    ->get();

                foreach ($students as $sessionStudent) {
                    MarksRegisterChildren::create([
                        'marks_register_id' => $markRegister->id,
                        'student_id'        => $sessionStudent->student_id,
                        'title'             => 'Written',
                        'mark'              => rand(55, 98),
                        'branch_id'         => $branchId,
                    ]);
                    self::$marksRegisterCount++;
                }
            }
        }
    }
}
