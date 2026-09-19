<?php

namespace App\Repositories\Fees;

use App\Interfaces\Fees\FeesGroupInterface;
use App\Models\Fees\FeesGroup;
use App\Traits\ReturnFormatTrait;

class FeesGroupRepository implements FeesGroupInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(FeesGroup $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function onlineAdmissionFeesMasters()
    {
        return $this->model->active()->where('online_admission_fees',1)->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->paginate(10);
    }

    public function store($request)
    {
        try {
            $row                = new $this->model;
            $row->name          = $request->name;
            $row->description   = $request->description;
            $row->status        = $request->status;
            $row->online_admission_fees        = $request->online_admission_fees ?? 0;
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
            $row                = $this->model->findOrfail($id);
            $row->name          = $request->name;
            $row->description   = $request->description;
            $row->status        = $request->status;
            $row->online_admission_fees        = $request->online_admission_fees ?? $row->online_admission_fees;
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
