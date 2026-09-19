<?php

namespace App\Repositories\Report;

use App\Traits\ReturnFormatTrait;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Interfaces\Report\MarksheetInterface;
use App\Interfaces\Report\ProgressCardInterface;

class ProgressCardRepository implements ProgressCardInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {

        $subjects = MarksRegister::where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->select('subject_id')
            ->distinct('subject_id')
            ->get();

        $exams = MarksRegister::where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->select('exam_type_id')
            ->distinct('exam_type_id')
            ->get();


        $data                   = [];
        $data['subjects']       = $subjects;
        $data['exams']          = $exams;





        foreach ($exams as $key => $value) {

            $marks_registers = MarksRegister::where('session_id', setting('session'))
                ->where('exam_type_id', $value->exam_type_id)
                ->where('classes_id', $request->class)
                ->where('section_id', $request->section)
                ->with('marksRegisterChilds', function ($query) use ($request) {
                    $query->where('student_id', $request->student);
                })->get();

            $result      = ___('examination.Passed');
            $total_marks = 0;
            foreach ($marks_registers as $marks_register) {
                $total_marks += $marks_register->marksRegisterChilds->sum('mark');
                if ($marks_register->marksRegisterChilds->sum('mark') < examSetting('average_pass_marks')) {
                    $result = ___('examination.Failed');
                }
            }

            $grades = MarksGrade::where('session_id', setting('session'))->get();
            $gpa = '';
            foreach ($grades as $grade) {
                if ($grade->percent_from <= $total_marks / count($marks_registers) && $grade->percent_upto >= $total_marks / count($marks_registers)) {
                    $gpa = $grade->point;
                }
            }

            $data['marks_registers'][] = $marks_registers;
            $data['result'][]          = $result;
            $data['gpa'][]             = $gpa;
            $data['total_marks'][]     = $total_marks;
            $data['avg_marks'][]       = $total_marks / count($marks_registers);

        }
        
        return $data;
    }
}
