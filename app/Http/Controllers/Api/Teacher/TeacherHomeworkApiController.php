<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Homework;
use Illuminate\Http\Request;
use App\Models\Academic\Classes;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\Homework\HomeworkRepository;
use App\Http\Resources\Teacher\Api\HomeworkListResource;
use App\Http\Resources\Teacher\Api\HomeworkStudentListResource;
use App\Http\Requests\Examination\Homework\HomeworkStoreRequest;
use App\Models\HomeworkStudent;

class TeacherHomeworkApiController extends Controller
{

    use ApiReturnFormatTrait;

    private $hw_repo ;

    function __construct(HomeworkRepository $hw_repo)
    {
        $this->hw_repo = $hw_repo;
    }

    public function list(){
        try {

             $homeworks = Homework::whereIn('subject_id', teacherSubjects())->orderBy('date','desc')->with(['subject:id,name','class:id,name','section:id,name','upload:id,path'])->paginate(10);
             HomeworkListResource::collection($homeworks);
            return $this->responseWithSuccess('Homework List', $homeworks, 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), 400);
        }
    }





    public function store(Request $request){
        try {
            $validate = Validator::make($request->all(), [
                'class'              => 'required',
                'section'            => 'required',
                'subject'            => "required",
                'date'               => "required",
                'marks'              => "required",
                'document'           => "file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xlsx,xls,csv|max:2048",
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Error', $validate->errors(), 422);
            }

            $result = $this->hw_repo->store($request);
            if($result['status']){
                return $this->responseWithSuccess('Homework Store', null, 200);
            }

            return $this->responseWithSuccess('Homework Store Failed', null, 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), 400);
        }
    }



    public function update(Request $request){
        try {
            $validate = Validator::make($request->all(), [
                'id'                 => 'required',
                'class'              => 'required',
                'section'            => 'required',
                'subject'            => "required",
                'date'               => "required",
                'marks'              => "required",
                'document'           => "file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xlsx,xls,csv|max:2048",
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Error', $validate->errors(), 422);
            }

            $result = $this->hw_repo->update($request, $request->id);
            if($result['status']){
                return $this->responseWithSuccess('Homework Updated', null, 200);
            }

            return $this->responseWithSuccess('Homework Update Failed', null, 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), null, 400);
        }
    }



    public function delete(Request $request){
        try {
            $validate = Validator::make($request->all(), [
                'id'                 => 'required'
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Error', $validate->errors(), 422);
            }

            $result = $this->hw_repo->destroy($request->id);

            if($result['status']){
                return $this->responseWithSuccess('Homework Delete', $result['status'], 200);
            }

            return $this->responseWithSuccess('Homework Delete Failed', $result, 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), 400);
        }
    }



    public function evaluateStudents($id){

        $homework = $this->hw_repo->show($id);
        try {
            $student_list  = SessionClassStudent::with(['student', 'homeworkStudent.homeworkUpload', 'homeworkStudent' => function ($query) use ($homework) {
                $query->where('homework_id', $homework->id);
            }])
            ->where('session_id', $homework->session_id)
            ->where('classes_id', $homework->classes_id)
            ->where('section_id', $homework->section_id)
            ->get();

            $students = HomeworkStudentListResource::collection($student_list);

            return $this->responseWithSuccess('Student List', $students, 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), [], 400);
        }
    }



    public function evaluateStudentmark(Request $request){
        $validate = Validator::make($request->all(), [
            'homework'           => 'required',
            'students'           => 'required|array',
            'marks'             => 'required|array'
        ]);

        if($validate->fails()){
            return $this->responseWithError('Validation Error', $validate->errors(), 422);
        }

        try {
            $students_ids = $request->students;
            $marks = $request->marks;
            foreach($students_ids as $key=>$student){
                $submitted =  HomeworkStudent::where('student_id',$student)->where('homework_id',$request->homework)->first();
                if($submitted){
                    $submitted->marks = $marks[$key];
                    $submitted->update();
                }
            }

            return $this->responseWithSuccess('Student Homework Evaluation', [], 200);
        } catch (\Throwable $th) {
           return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
