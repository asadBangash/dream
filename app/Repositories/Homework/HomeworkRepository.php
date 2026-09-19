<?php

namespace App\Repositories\Homework;

use App\Models\Homework;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\Homework\HomeworkInterface;

class HomeworkRepository implements HomeworkInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(Homework $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->orderByDesc('id')->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->whereIn('subject_id', teacherSubjects())->orderByDesc('id')->paginate(10);
    }

    public function search($request)
    {
        $rows = $this->model::query();
        $rows = $rows->where('session_id', setting('session'));
        if($request->class != "") {
            $rows = $rows->where('classes_id', $request->class);
        }
        if($request->section != "") {
            $rows = $rows->where('section_id', $request->section);
        }
        if($request->subject != "") {
            $rows = $rows->where('subject_id', $request->subject);
        }
        return $rows->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $row                   = new $this->model;
            $row->session_id       = setting('session');
            $row->classes_id         = $request->class;
            $row->section_id       = $request->section;
            $row->subject_id       = $request->subject;

            $row->date                  = $request->date;
            $row->submission_date       = $request->submission_date;

            $row->marks             = $request->marks;
            $row->status            = $request->status ?? 1;
            $row->document_id       = $this->UploadImageCreate($request->document, 'backend/uploads/homeworks');
            $row->description       = $request->description;

            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th) ;
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $row                   = $this->model->find($id);
            $row->session_id       = setting('session');
            $row->classes_id       = $request->class;
            $row->section_id       = $request->section;
            $row->subject_id       = $request->subject;

            $row->date                  = $request->date;
            $row->submission_date       = $request->submission_date;

            $row->marks             = $request->marks;
            $row->status            = $request->status ?? 1;
            $row->document_id       = $this->UploadImageUpdate($request->document, 'backend/uploads/homeworks', $row->document_id);
            $row->description       = $request->description;

            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $this->UploadImageDelete($row->document_id);
            $row->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function evaluationSubmit($request)
    {

        DB::beginTransaction();
        try {

            foreach ($request->students as $key => $student) {
                $homework        = HomeworkStudent::where('homework_id', $request->homework_id)->where('student_id', $student)->first();
                $homework->marks = $request->marks[$key];
                $homework->save();

            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.submitted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
