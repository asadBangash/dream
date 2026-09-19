<?php

namespace App\Repositories\Library;

use App\Enums\Settings;
use App\Interfaces\Library\MemberInterface;
use App\Models\Library\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;

class MemberRepository implements MemberInterface{

    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;

    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $row                   = new $this->model;
            $row->user_id          = $request->member;
            $row->category_id      = $request->category;
            $row->status           = $request->status;
            $row->save();

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
            $row                   = $this->model->findOrfail($id);
            $row->user_id          = $request->member;
            $row->category_id      = $request->category;
            $row->status           = $request->status;
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
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getMember($request)
    {
        return User::where('name', 'like', '%' . $request->text . '%')->pluck('name','id')->take(10)->toArray();
    }

    public function getUser($id)
    {
        return User::where('id', $id)->pluck('name')->first();
    }
}
