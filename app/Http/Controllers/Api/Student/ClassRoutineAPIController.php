<?php

namespace App\Http\Controllers\Api\Student;

use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Academic\ClassRoutineChildren;
use App\Http\Resources\Student\StudentClassRoutineResource;

class ClassRoutineAPIController extends Controller
{
    use ReturnFormatTrait;
    
    public function index()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $dayNum                 = getDayNum(request('date'));
            $routines               = ClassRoutineChildren::query()
                                    ->whereHas('classRoutine', function ($q) use ($sessionClassStudent, $dayNum) {
                                        $q->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id)
                                        ->where('session_id', $sessionClassStudent->session_id)
                                        ->where('day', $dayNum);
                                    })
                                    ->with(['classRoutine' => function ($q) use ($sessionClassStudent, $dayNum) {
                                        $q->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id)
                                        ->where('session_id', $sessionClassStudent->session_id)
                                        ->where('day', $dayNum);
                                    }])
                                    ->whereHas('timeSchedule', fn ($q) => $q->class()->active())
                                    ->with(['timeSchedule' => fn ($q) => $q->class()->active()])
                                    ->whereHas('subject', fn ($q) => $q->active())
                                    ->with(['subject' => fn ($q) => $q->active()])
                                    ->whereHas('classRoom', fn ($q) => $q->active())
                                    ->with(['classRoom' => fn ($q) => $q->active()])
                                    ->get();
                                
            $data                   = StudentClassRoutineResource::collection($routines);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
