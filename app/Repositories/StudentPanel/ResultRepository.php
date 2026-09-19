<?php

namespace App\Repositories\StudentPanel;

use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksGrade;
use App\Models\Examination\MarksRegister;
use App\Models\Examination\MarksRegisterChildren;

class ResultRepository
{
    public function result($exam_type_id)
    {
        $sessionClassStudent    = sessionClassStudent();

        $studentMark            = MarksRegisterChildren::query()
                                ->where('student_id', $sessionClassStudent->student_id)
                                ->whereHas('MarksRegister', function ($q) use ($sessionClassStudent, $exam_type_id) {
                                    $q->where('exam_type_id', $exam_type_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id);
                                });

        $studentAllMarkClone    = clone $studentMark;
        $studentTotalMarkClone  = clone $studentMark;

        $totalMark              = $studentTotalMarkClone->sum('mark');

        $isFail                 = $studentAllMarkClone->where('mark', '<', examSetting('average_pass_marks'))->count();
        $status                 = $isFail ? ___('examination.Failed') : ___('examination.Passed');

        $subject_ids            = MarksRegister::query()
                                ->where('exam_type_id', $exam_type_id)
                                ->where('session_id', $sessionClassStudent->session_id)
                                ->where('classes_id', $sessionClassStudent->classes_id)
                                ->where('section_id', $sessionClassStudent->section_id)
                                ->whereHas('marksRegisterChilds', function ($query) use ($sessionClassStudent) {
                                    $query->where('student_id', $sessionClassStudent->student_id);
                                })
                                ->pluck('subject_id')
                                ->toArray();

        $allSubjectTotalMark    = ExamAssign::query()
                                ->whereIn('subject_id', $subject_ids)
                                ->where('exam_type_id', $exam_type_id)
                                ->where('session_id', $sessionClassStudent->session_id)
                                ->where('classes_id', $sessionClassStudent->classes_id)
                                ->where('section_id', $sessionClassStudent->section_id)
                                ->sum('total_mark');
                                
        $percentage             = $allSubjectTotalMark > 0 ? (int) number_format(($totalMark / $allSubjectTotalMark) * 100, 2) : 0;

        $markGrade              = MarksGrade::query()
                                ->active()
                                ->where('session_id', $sessionClassStudent->session_id)
                                ->where('percent_from', '<=', $percentage)
                                ->where('percent_upto', '>=', $percentage)
                                ->first();

        $grade                  = null;
        $gpa                    = 0;

        if (!$isFail && $markGrade) {
            $grade              = $markGrade->name;
            $gpa                = $markGrade->point;
        }

        $data['status']         = $status;
        $data['grade']          = $grade;
        $data['number']         = $totalMark;
        $data['gpa']            = $gpa;
        $data['marksheet_pdf']  = route('student.marksheet-pdf', ['exam_type_id' => $exam_type_id]) . '?student_id=' . $sessionClassStudent->student_id;

        return $data;
    }
}
