<?php

namespace App\Http\Controllers\Api\Student;

use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Academic\ExamRoutine;
use App\Models\Examination\ExamType;

class ExamRoutineAPIController extends Controller
{
    use ReturnFormatTrait;
    
    public function __invoke()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $exam_type_id           = ExamType::active()
                                    ->whereHas('examRoutines', function ($q) use ($sessionClassStudent) {
                                        $q->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->first()?->id;
            
            $examStartDate          = ExamRoutine::where('type_id', request('exam_type_id') ?? $exam_type_id)->first()?->date;
            $examEndDate            = ExamRoutine::where('type_id', request('exam_type_id') ?? $exam_type_id)->orderBy('id', 'Desc')->first()?->date;

            if (!$examStartDate) {
                return $this->responseWithError(___('alert.no_data_found'), []);
            }

            $data                   = [
                'start_date'        => $examStartDate ? date('d M Y', strtotime($examStartDate)) : null,
                'end_date'          => $examEndDate ? date('d M Y', strtotime($examEndDate)) : null,
            ];

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
