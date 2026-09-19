<?php

namespace App\Http\Controllers\Api\Student;

use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Academic\SubjectAssignChildren;
use App\Http\Resources\Student\StudentSubjectResource;

class SubjectAPIController extends Controller
{
    use ReturnFormatTrait;

    public function __invoke()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $subjects               = SubjectAssignChildren::query()
                                    ->where('status', 1)
                                    ->whereHas('subjectAssign', function ($q) use ($sessionClassStudent) {
                                        $q->active()
                                        ->where('session_id', $sessionClassStudent->session_id)
                                        ->where('classes_id', $sessionClassStudent->classes_id)
                                        ->where('section_id', $sessionClassStudent->section_id);
                                    })
                                    ->whereHas('subject', fn ($q) => $q->active())
                                    ->get();

            $data['total']          = $subjects->count();
            $data['items']          = StudentSubjectResource::collection($subjects);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
