<?php

namespace App\Repositories\Examination;

use App\Interfaces\Examination\MarksGradeInterface;;
use App\Models\Examination\MarksGrade;
use App\Traits\ReturnFormatTrait;

class MarksGradeRepository implements MarksGradeInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(MarksGrade $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->paginate(10);
    }

    public function store($request)
    {
        try {

            if($this->model::where('session_id', setting('session'))->where('name', $request->name)->first()) {
                return $this->responseWithError(___('alert.There is already a grade for this session.'), []);
            }

            $row                   = new $this->model;
            $row->name             = $request->name;
            $row->point            = $request->point;
            $row->percent_from     = $request->percent_from;
            $row->percent_upto     = $request->percent_upto;
            $row->remarks          = $request->remarks;
            $row->session_id       = setting('session');
            $row->status           = $request->status;
            $row->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);

        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {

            if($this->model::where('session_id', setting('session'))->where('name', $request->name)->where('id', '!=', $id)->first()) {
                return $this->responseWithError(___('alert.There is already a grade for this session.'), []);
            }
            $row                   = $this->model->findOrfail($id);
            $row->name             = $request->name;
            $row->point            = $request->point;
            $row->percent_from     = $request->percent_from;
            $row->percent_upto     = $request->percent_upto;
            $row->remarks          = $request->remarks;
            $row->session_id       = setting('session');
            $row->status           = $request->status;
            $row->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
