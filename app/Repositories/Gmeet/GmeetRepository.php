<?php

namespace App\Repositories\Gmeet;

use App\Models\Gmeet;
use App\Models\Session;
use App\Models\Homework;
use App\Models\Certificate;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\Gmeet\GmeetInterface;
use App\Models\StudentInfo\SessionClassStudent;

class GmeetRepository implements GmeetInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(Gmeet $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderByDesc('id')->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->orderByDesc('id')->paginate(10);
    }


    public function getPaginateClassBySubjectIds($subject_ids)
    {
        return $this->model::latest()->orderByDesc('id')->whereIn('subject_id',$subject_ids)->with('subject:id,name','class:id,name','section:id,name')->paginate(10);
    }

    public function search($request)
    {
        $rows = $this->model::query();
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
        // DB::beginTransaction();
        // try {

            $row                    = new $this->model;
            $row->title             = $request->title;
            $row->gmeet_link        = $request->gmeet_link;
            $row->session_id        = setting('session');
            $row->classes_id        = $request->class;
            $row->section_id        = $request->section;
            if($request->subject != "")
                $row->subject_id    = $request->subject;

            $row->start             = $request->start;
            $row->end               = $request->end;
            $row->status               = $request->status;
            $row->description               = $request->description;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        // }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        // DB::beginTransaction();
        // try {
            $row                     = $this->model->find($id);
            $row->title             = $request->title;
            $row->gmeet_link             = $request->gmeet_link;
            $row->session_id        = setting('session');
            $row->classes_id        = $request->class;
            $row->section_id        = $request->section;
            if($request->subject != "")
                $row->subject_id    = $request->subject;

            $row->start             = $request->start;
            $row->end               = $request->end;
            $row->status               = $request->status;
            $row->description               = $request->description;

            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        // }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $row = $this->model->find($id);
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

}
