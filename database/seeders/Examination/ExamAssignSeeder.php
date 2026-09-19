<?php

namespace Database\Seeders\Examination;

use Illuminate\Database\Seeder;
use App\Models\Academic\Classes;
use App\Models\Examination\ExamType;
use App\Models\Academic\SubjectAssign;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\ExamAssignChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams    = ExamType::all();
        $classes  = Classes::all();

        foreach ($exams as $exam) {

            foreach ($classes as $class) {

                foreach ($class->classSetup->classSetupChildrenAll as $setup_child) {
                    $assigned_subjects = SubjectAssign::with('subjectTeacher')->where('classes_id', $class->id)->where('section_id', $setup_child->section_id)->first();

                    foreach($assigned_subjects->subjectTeacher as $subject) {

                        $exam_assign               = new ExamAssign();
                        $exam_assign->session_id   = setting('session');
                        $exam_assign->classes_id   = $class->id;
                        $exam_assign->section_id   = $setup_child->section_id;
                        $exam_assign->exam_type_id = $exam->id;
                        $exam_assign->subject_id   = $subject->subject_id;
                        $exam_assign->total_mark   = 100;
                        $exam_assign->save();

                        $exam_assign_child                    = new ExamAssignChildren();
                        $exam_assign_child->exam_assign_id    = $exam_assign->id;
                        $exam_assign_child->title             = 'Written';
                        $exam_assign_child->mark              = 100;
                        $exam_assign_child->save();

                    }
                }

            }

        }

    }
}
