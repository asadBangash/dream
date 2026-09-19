<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExaminationResult;
use Illuminate\Support\Facades\DB;
use App\Models\Academic\ClassSetup;
use Illuminate\Support\Facades\Log;
use App\Models\Academic\SubjectAssign;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Models\StudentInfo\SessionClassStudent;

class ExamResultGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:result-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {

            ini_set('max_execution_time', '300');

            $class_setups  = ClassSetup::where('session_id', setting('session'))->get();
            $grades        = MarksGrade::where('session_id', setting('session'))->get();

            foreach ($class_setups as $class_setup) {

                foreach ($class_setup->classSetupChildrenAll as $class_setup_child) {

                    $exam_types = ExamAssign::where('session_id', setting('session'))
                                            ->where('classes_id', $class_setup->classes_id)
                                            ->where('section_id', $class_setup_child->section_id)
                                            ->distinct()->pluck('exam_type_id');


                    $assigned_subjects = SubjectAssign::with('subjectTeacher')->where('classes_id', $class_setup->classes_id)->where('section_id', $class_setup_child->section_id)->where('session_id', setting('session'))->first();
                    $students          = SessionClassStudent::where('classes_id', $class_setup->classes_id)->where('section_id', $class_setup_child->section_id)->where('session_id', setting('session'))->get();


                    foreach ($exam_types as $exam_type) {

                        foreach ($students as $student) {

                            $examinationResult = ExaminationResult::where('student_id', $student->student_id)
                                                                    ->where('exam_type_id', $exam_type)
                                                                    ->where('session_id', setting('session'))
                                                                    ->first();


                            if(!$examinationResult) { // if aready registerd then ignore for this student-exam-wise-for-session

                                $result      = ___('examination.Passed');
                                $total_marks = 0;

                                foreach ($assigned_subjects->subjectTeacher as $assigned_subject) {

                                    $marks_register = MarksRegister::where('exam_type_id', $exam_type)
                                                                    ->where('classes_id', $class_setup->classes_id)
                                                                    ->where('section_id', $class_setup_child->section_id)
                                                                    ->where('session_id', setting('session'))
                                                                    ->where('subject_id', $assigned_subject->subject_id)
                                                                    ->with('marksRegisterChilds', function ($query) use($student) {
                                                                        $query->where('student_id', $student->student_id);
                                                                    })->first();
                          


                                    $total_marks += $marks_register->marksRegisterChilds->sum('mark');
                                    if($marks_register->marksRegisterChilds->sum('mark') < examSetting('average_pass_marks')) {
                                        $result = ___('examination.Failed');
                                    }

                                }

                                $grade_point = '';
                                $grade_name = '';
                                foreach($grades as $grade) {
                                        if($grade->percent_from <= round($total_marks/count($assigned_subjects->subjectTeacher)) && $grade->percent_upto >= round($total_marks/count($assigned_subjects->subjectTeacher))) {
                                            $grade_point = $grade->point;
                                            $grade_name = $grade->name;
                                        }
                                }


                                if($grade_name == '') {
                                    Log::info(round($total_marks/count($assigned_subjects->subjectTeacher)));

                                    Log::info($total_marks);
                                    Log::info(round(count($assigned_subjects->subjectTeacher)));
                                }

                                $examinationResult               = new ExaminationResult();
                                $examinationResult->session_id   = setting('session');
                                $examinationResult->classes_id   = $class_setup->classes_id;
                                $examinationResult->section_id   = $class_setup_child->section_id;
                                $examinationResult->exam_type_id = $exam_type;
                                $examinationResult->student_id   = $student->student_id;
                                $examinationResult->result       = $result;
                                $examinationResult->grade_name   = $result == 'Passed' ? $grade_name : 'F';
                                $examinationResult->grade_point  = $result == 'Passed' ? $grade_point :'0.00';
                                $examinationResult->total_marks  = $total_marks;
                                $examinationResult->save();

                            }
                        }

                        // position/rank information

                        $examinationResults = ExaminationResult::where('classes_id', $class_setup->classes_id)
                                                                    ->where('section_id', $class_setup_child->section_id)
                                                                    ->where('exam_type_id', $exam_type)
                                                                    ->where('session_id', setting('session'))
                                                                    ->orderBy('total_marks', 'desc')
                                                                    ->where('position', null)
                                                                    ->get();

                        foreach ($examinationResults as $key=>$examinationResult) {
                            $examinationResult->position = $key + 1;
                            $examinationResult->save();
                        }

                    }

                }

            }

            DB::commit();
            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollback();
            return Command::FAILURE;
        }

    }
}
