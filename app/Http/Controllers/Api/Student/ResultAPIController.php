<?php

namespace App\Http\Controllers\Api\Student;

use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Examination\ExamType;
use App\Models\Examination\MarksRegister;
use App\Http\Resources\Student\ResultResource;

class ResultAPIController extends Controller
{
    use ReturnFormatTrait;

    
    public function index()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            
            $sessionClassStudent    = sessionClassStudent();

            $examTypes              = ExamType::query()
                                    ->whereHas('markRegisters', function ($q) use ($sessionClassStudent) {
                                        $q->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->get();

            $data                   = ResultResource::collection($examTypes);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
