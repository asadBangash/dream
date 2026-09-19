<?php

namespace App\Repositories\Examination;

use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Examination\MarksRegister;
use App\Models\Examination\MarksRegisterChildren;
use App\Interfaces\Examination\MarksRegisterInterface;;

class MarksRegisterRepository implements MarksRegisterInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(MarksRegister $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->whereIn('subject_id', teacherSubjects())->paginate(10);
    }

    public function searchMarkRegister($request)
    {
        $rows = $this->model::query();
        $rows = $rows->where('session_id', setting('session'));
        if ($request->class != "") {
            $rows = $rows->where('classes_id', $request->class);
        }
        if ($request->section != "") {
            $rows = $rows->where('section_id', $request->section);
        }
        if ($request->exam_type != "") {
            $rows = $rows->where('exam_type_id', $request->exam_type);
        }
        if ($request->subject != "") {
            $rows = $rows->where('subject_id', $request->subject);
        }
        return $rows->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            if ($this->model::where('session_id', setting('session'))->where('classes_id', $request->class)->where('section_id', $request->section)->where('exam_type_id', $request->exam_type)->where('subject_id', $request->subject)->first()) {
                return $this->responseWithError(___('alert.There is already a register for this session.'), []);
            }

            $row                   = new $this->model;
            $row->session_id       = setting('session');
            $row->classes_id         = $request->class;
            $row->section_id       = $request->section;
            $row->exam_type_id     = $request->exam_type;
            $row->subject_id       = $request->subject;
            $row->save();

            foreach ($request->student_ids as $id) {
                foreach ($request->marks[$id] as $key => $mark) {
                    $rowChild                     = new MarksRegisterChildren();
                    $rowChild->marks_register_id  = $row->id;
                    $rowChild->student_id         = $id;
                    $rowChild->title              = $key;
                    $rowChild->mark               = $mark;
                    $rowChild->save();
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
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

            if ($this->model::where('session_id', setting('session'))->where('classes_id', $request->class)->where('section_id', $request->section)->where('exam_type_id', $request->exam_type)->where('subject_id', $request->subject)->where('id', '!=', $id)->first()) {
                return $this->responseWithError(___('alert.There is already a register for this session.'), []);
            }

            $row                   = $this->model->find($id);
            $row->session_id       = setting('session');
            $row->classes_id         = $request->class;
            $row->section_id       = $request->section;
            $row->exam_type_id     = $request->exam_type;
            $row->subject_id       = $request->subject;
            $row->save();

            MarksRegisterChildren::where('marks_register_id', $row->id)->delete();

            foreach ($request->student_ids as $id) {
                foreach ($request->marks[$id] as $key => $mark) {
                    $rowChild                     = new MarksRegisterChildren();
                    $rowChild->marks_register_id  = $row->id;
                    $rowChild->student_id         = $id;
                    $rowChild->title              = $key;
                    $rowChild->mark               = $mark;
                    $rowChild->save();
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function updateMarksheetStatus($request, $id)
    {
        try {

            $row                   = $this->model->find($id);
            $row->is_marksheet_published       = $request->action === 'unpublish' ? 0 : 1;
            $row->save();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            MarksRegisterChildren::where('marks_register_id', $row->id)->delete();
            $row->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
