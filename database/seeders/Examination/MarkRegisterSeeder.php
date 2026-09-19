<?php

namespace Database\Seeders\Examination;

use Illuminate\Database\Seeder;
use App\Models\Academic\Classes;
use App\Models\Examination\ExamType;
use App\Models\Academic\SubjectAssign;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Models\Examination\ExamAssignChildren;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\Examination\MarksRegisterChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarkRegisterSeeder extends Seeder
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

                    $assigned_subjects = SubjectAssign::with('subjectTeacher')->where('classes_id', $class->id)->where('section_id', $setup_child->section_id)->where('session_id', setting('session'))->first();
                    $students          = SessionClassStudent::where('classes_id', $class->id)->where('section_id', $setup_child->section_id)->where('session_id', setting('session'))->get();

                    foreach($assigned_subjects->subjectTeacher as $subject) {

                        $mark_register               = new MarksRegister();
                        $mark_register->session_id   = setting('session');
                        $mark_register->classes_id   = $class->id;
                        $mark_register->section_id   = $setup_child->section_id;
                        $mark_register->exam_type_id = $exam->id;
                        $mark_register->subject_id   = $subject->subject_id;
                        $mark_register->save();

                        foreach($students as $student) {

                            $mark_register_child                      = new MarksRegisterChildren();
                            $mark_register_child->marks_register_id   = $mark_register->id;
                            $mark_register_child->student_id          = $student->student_id;
                            $mark_register_child->title               = 'Written';
                            $mark_register_child->mark                = rand(30,100);
                            $mark_register_child->save();

                        }

                    }
                }

            }

        }

    }
}
