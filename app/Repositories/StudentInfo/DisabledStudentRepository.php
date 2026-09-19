<?php

namespace App\Repositories\StudentInfo;

use App\Enums\Status;
use App\Interfaces\StudentInfo\DisabledStudentInterface;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\SessionClassStudent;

class DisabledStudentRepository implements DisabledStudentInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {
        try {
            $students = SessionClassStudent::where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section);

            $students = $students->whereHas('student', function ($query) {
                return $query->where('status', Status::INACTIVE);
            });
            
            return $students->get();
            
            return $this->responseWithSuccess(___('alert.get_successfully'), $students);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
