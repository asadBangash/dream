<?php

namespace App\Repositories\StudentInfo;

use App\Enums\ApiStatus;
use App\Traits\ReturnFormatTrait;
use App\Models\StudentInfo\PromoteStudent;
use App\Interfaces\StudentInfo\PromoteStudentInterface;
use App\Models\Academic\ClassSetup;
use App\Models\Academic\ClassSetupChildren;
use App\Models\ExaminationResult;
use App\Models\StudentInfo\SessionClassStudent;

class PromoteStudentRepository implements PromoteStudentInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(PromoteStudent $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->paginate(10);
    }

    public function search($request)
    {
        try {
            $ids = SessionClassStudent::where('session_id', $request->promote_session)
            ->where('classes_id', $request->promote_class)
            ->where('section_id', $request->promote_section)
            ->pluck('student_id');

            
            $students = SessionClassStudent::where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->whereNotIn('student_id', $ids)
            ->get();

            
            $examResults = ExaminationResult::where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->whereNotIn('student_id', $ids)
            ->select('student_id','result')
            ->get();
            
            
            $results = [];
            foreach ($students as $student) {
                $items = [];
                foreach ($examResults as $result) {
                    if ($student->student_id == $result->student_id) {
                        $items[] = $result->result == 'Failed' ? 'Fail' : 'Pass';
                    }
                }
                foreach ($items as $item) {
                    if($item == 'Fail'){
                        $results[$student->student_id] = 'Fail';
                        break;
                    }else
                        $results[$student->student_id] = 'Pass';
                }
            }

            $data['students'] = $students;
            $data['results']  = $results;
            

            return $this->responseWithSuccess(___('alert.get_successfully'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function store($request)
    {
        try {
            if($request->students == null)
                return $this->responseWithError(___('alert.Please select students'), []);

            foreach ($request->students as $key=>$value) {
                $row                     = new SessionClassStudent;
                $row->session_id         = $request->promote_session;
                $row->classes_id           = $request->promote_class;
                $row->section_id         = $request->promote_section;

                $row->student_id         = $value[0];
                $row->result             = $request->result[$key][0];
                $row->roll               = $request->roll[$key][0];
                $row->save();
            }
            return $this->responseWithSuccess(___('alert.Promote successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getClass($request)
    {
        return ClassSetup::where('session_id', $request->id)->with('class')->get();
    }

    public function getSections($request)
    {
        $result = ClassSetup::where('session_id', $request->session)->where('classes_id', $request->class)->with('classSetupChildrenAll')->first();
        return ClassSetupChildren::where('class_setup_id', $result->id)->with('section')->get();
    }
}
