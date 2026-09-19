<?php

namespace App\Http\Controllers\Api\Parent;

use App\Models\Event;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\StudentResource;
use App\Models\StudentInfo\SessionClassStudent;

class StudentAPIController extends Controller
{
    use ReturnFormatTrait;

    public function index()
    {
        try {

            $student_ids    = SessionClassStudent::query()
                            ->whereHas('student', fn ($q) => $q->where('parent_guardian_id', @auth()->user()->parent->id))
                            ->where('session_id', setting('session'))
                            ->pluck('student_id')
                            ->toArray();

            $students       = Student::query()
                            ->whereIn('id', $student_ids)
                            ->get();

            $data           = StudentResource::collection($students);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
