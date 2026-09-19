<?php

namespace App\Repositories\Report;

use App\Models\ExaminationResult;
use App\Traits\ReturnFormatTrait;
use App\Interfaces\Report\MeritListInterface;

class MeritListRepository implements MeritListInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {

        $students = ExaminationResult::query();
        $students = $students->where('session_id', setting('session'));

        if($request->class != "") {
            $students = $students->where('classes_id', $request->class);
        }
        if($request->section != "") {
            $students = $students->where('section_id', $request->section);
        }
        if($request->exam_type != "") {
            $students = $students->where('exam_type_id', $request->exam_type);
        }
        if($request->shift != "") {
            $students = $students->whereHas('student', function ($query) use ($request) {
                $query->whereHas('session_class_student', function ($query) use($request) {
                    $query->where('session_id', setting('session'))->where('shift_id', $request->shift);
                });
            });
        }

        $students  = $students->orderBy('position')->paginate(10);
        return $students;
    }

    public function searchPDF($request)
    {
        $students = ExaminationResult::query();
        $students = $students->where('session_id', setting('session'));

        if($request->class != "") {
            $students = $students->where('classes_id', $request->class);
        }
        if($request->section != "") {
            $students = $students->where('section_id', $request->section);
        }
        if($request->exam_type != "") {
            $students = $students->where('exam_type_id', $request->exam_type);
        }

        $students  = $students->orderBy('position')->with(['student:id,first_name,last_name,full_name,admission_no','class:id,name','section:id,name'])->get();
        return $students;
    }
}
