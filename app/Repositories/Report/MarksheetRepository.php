<?php

namespace App\Repositories\Report;

use App\Traits\ReturnFormatTrait;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Interfaces\Report\MarksheetInterface;

class MarksheetRepository implements MarksheetInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {
        
        $marks_registers = MarksRegister::where('exam_type_id', $request->exam_type)
                                        ->where('classes_id', $request->class)
                                        ->where('section_id', $request->section)
                                        ->where('session_id', setting('session'))
                                        ->with('marksRegisterChilds', function ($query) use($request) {
                                            $query->where('student_id', $request->student);
                                           })->get();


        $result      = ___('examination.Passed');
        $total_marks = 0;
        foreach($marks_registers as $marks_register) {
            $total_marks += $marks_register->marksRegisterChilds->sum('mark');
            if($marks_register->marksRegisterChilds->sum('mark') < examSetting('average_pass_marks')) {
                $result = ___('examination.Failed');
            }
        }

       $grades = MarksGrade::where('session_id', setting('session'))->get();
       $gpa = '';
       foreach($grades as $grade) {
            if($grade->percent_from <= $total_marks/count($marks_registers) && $grade->percent_upto >= $total_marks/count($marks_registers)) {
                $gpa = $grade->point;
            }
       }

       $data = [];
       $data['marks_registers'] = $marks_registers;
       $data['result']          = $result;
       $data['gpa']             = $gpa;
       $data['avg_marks']       = $total_marks/count($marks_registers);

       return $data;


    }
}
