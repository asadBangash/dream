<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\User;
use App\Models\Staff\Staff;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Academic\SubjectAssignChildren;
use App\Http\Resources\Student\TeacherResource;
use App\Http\Resources\Student\TeacherSubjectResource;

class TeacherAPIController extends Controller
{
    use ReturnFormatTrait;

    
    public function currentSessionTeachers()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
           
            $sessionClassStudent    = sessionClassStudent();

            $teacher_ids            = SubjectAssignChildren::query()
                                    ->whereHas('subjectAssign', function ($q) use ($sessionClassStudent) {
                                        $q->active()
                                        ->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->whereHas('subject', fn ($q) => $q->active())
                                    ->pluck('staff_id')
                                    ->toArray();

            $teachers               = Staff::whereIn('id', $teacher_ids)->get();
            $teachers               = TeacherResource::collection($teachers);

            return $this->responseWithSuccess(___('alert.success'), $teachers);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }

    
    public function show($id)
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $request = request();
            $request->request->add(['is_details' => true]);

            $teachers   = Staff::where('id', $id)->take(1)->get();
            $teachers   = TeacherResource::collection($teachers);

            return $this->responseWithSuccess(___('alert.success'), $teachers[0]);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }


    public function assignSubjects($id)
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $subjects               = SubjectAssignChildren::query()
                                    ->where('staff_id', $id)
                                    ->where('status', 1)
                                    ->whereHas('subjectAssign', function ($q) use ($sessionClassStudent) {
                                        $q->active()
                                        ->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->whereHas('subject', fn ($q) => $q->active())
                                    ->get();
                                
            $subjects               = TeacherSubjectResource::collection($subjects);

            return $this->responseWithSuccess(___('alert.success'), $subjects);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
