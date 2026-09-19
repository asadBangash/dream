<?php

namespace App\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentDetailsResource;
use App\Models\StudentInfo\SessionClassStudent;

class TeacherStudentInfoController extends Controller
{
    use ReturnFormatTrait;
    public function studentList(Request $request)
    {
        try {
             $request->merge(array_map(function ($value) {
                    return $value === 'null' ? null : $value;
                }, $request->all()));
                
            if (auth()->user()->staff) {
                $subjectAssigns = auth()->user()->staff->subjectAssigns;

                 $class_ids = $subjectAssigns->pluck('classes_id')->unique();
                 $section_ids = $subjectAssigns->pluck('section_id')->unique();

                $filtered_class_ids = $request->filled('class_id')
                    ? (array) $request->class_id
                    : $class_ids;

                $filtered_section_ids = $request->filled('section_id')
                    ? (array) $request->section_id
                    : $section_ids;

                $student_ids = SessionClassStudent::query()
                    ->whereHas('student')
                    ->where('session_id', setting('session'))
                    ->whereIn('classes_id', $filtered_class_ids)
                    ->whereIn('section_id', $filtered_section_ids)
                    ->pluck('student_id');

                $students = Student::query()
                    ->whereIn('id', $student_ids)
                    ->with(['session_class_student', 'religion:id,name', 'gender:id,name', 'blood:id,name'])
                    ->when($request->filled('search_keyword'), function ($query) use ($request) {
                        $query->where('first_name', 'like', '%' . $request->search_keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search_keyword . '%')
                            ->orWhere('roll_no', 'like', '%' . $request->search_keyword . '%')
                            ->orWhere('email', 'like', '%' . $request->search_keyword . '%')
                            ->orWhere('mobile', 'like', '%' . $request->search_keyword . '%');
                    })
                    ->paginate($request->get('per_page', 10));
            }

            // Send resource with pagination meta
            $resource = StudentResource::collection($students ?? collect());

            return $this->responseWithSuccess(___('alert.success'), [
                'data' => $resource,
                'meta' => [
                    'current_page' => $students->currentPage(),
                    'last_page' => $students->lastPage(),
                    'per_page' => $students->perPage(),
                    'total' => $students->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 400);
        }
    }

    public function studentDetails($id)
    {
        try {
            $student = Student::with('session_class_student','religion:id,name','gender:id,name','blood:id,name')->find($id);
            return $this->responseWithSuccess(___('alert.success'), StudentDetailsResource::make($student));
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), 400);
        }
    }
}
