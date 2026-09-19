<?php

namespace App\Repositories\Fees;

use App\Models\Fees\FeesMaster;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Fees\FeesMasterChildren;
use App\Interfaces\Fees\FeesMasterInterface;
use App\Models\Fees\FeesGroup;

class FeesMasterRepository implements FeesMasterInterface
{
    use ReturnFormatTrait;

    private $model;

    private $feesGroup;

    public function __construct(FeesMaster $model, FeesGroup $feesGroup)
    {
        $this->model = $model;
        $this->feesGroup = $feesGroup;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function allGroups()
    {
        return $this->model->active()->select('fees_group_id')->distinct('fees_group_id')->get();
    }


    public function allFeesGroups()
    {
        return $this->feesGroup->active()->get();
    }

    public function groupTypes($request)
    {
        return $this->model->active()->where('fees_group_id', $request->id)->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id',setting('session'))->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            if ($this->model->where('session_id',setting('session'))->where('fees_group_id', $request->fees_group_id)->where('fees_type_id', $request->fees_type_id)->first())
                return $this->responseWithError(___('alert.there_is_already_assigned'), []);

            $row                = new $this->model;
            $row->session_id    = setting('session');
            $row->fees_group_id = $request->fees_group_id;
            $row->fees_type_id  = $request->fees_type_id;
            $row->due_date      = $request->due_date;
            $row->amount        = $request->amount;
            $row->fine_type     = $request->fine_type;
            $row->percentage    = $request->percentage;
            $row->fine_amount   = $request->fine_amount;
            $row->status        = $request->status;
            $row->save();

            // foreach ($request->fees_type_ids as $item) {
            //     $feesChield                 = new FeesMasterChildren();
            //     $feesChield->fees_master_id = $row->id;
            //     $feesChield->fees_type_id   = $item;
            //     $feesChield->save();
            // }
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

            if($this->model->where('session_id',setting('session'))->where('fees_group_id', $request->fees_group_id)->where('fees_type_id', $request->fees_type_id)->where('id', '!=', $id)->first())
                return $this->responseWithError(___('alert.there_is_already_assigned'), []);

            $row                = $this->model->findOrfail($id);
            $row->session_id    = setting('session');
            $row->fees_group_id = $request->fees_group_id;
            $row->fees_type_id  = $request->fees_type_id;
            $row->due_date      = $request->due_date;
            $row->amount        = $request->amount;
            $row->fine_type     = $request->fine_type;
            $row->percentage    = $request->percentage;
            $row->fine_amount   = $request->fine_amount;
            $row->status        = $request->status;
            $row->save();

            // FeesMasterChildren::where('fees_master_id', $row->id)->delete();

            // foreach ($request->fees_type_ids as $item) {
            //     $feesChield                 = new FeesMasterChildren();
            //     $feesChield->fees_master_id = $row->id;
            //     $feesChield->fees_type_id   = $item;
            //     $feesChield->save();
            // }

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
            FeesMasterChildren::where('fees_master_id', $row->id)->delete();
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
