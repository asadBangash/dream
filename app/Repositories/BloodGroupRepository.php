<?php

namespace App\Repositories;

use App\Enums\Settings;
use App\Interfaces\BloodGroupInterface;
use App\Models\BloodGroup;
use App\Traits\ReturnFormatTrait;

class BloodGroupRepository implements BloodGroupInterface
{
    use ReturnFormatTrait;
    private $bloodGroup;

    public function __construct(BloodGroup $bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;
    }

    public function all()
    {
        return $this->bloodGroup->active()->get();
    }

    public function getAll()
    {
        return $this->bloodGroup->latest()->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        try {
            $bloodGroupStore              = new $this->bloodGroup;
            $bloodGroupStore->name        = $request->name;
            $bloodGroupStore->status      = $request->status;
            $bloodGroupStore->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->bloodGroup->find($id);
    }

    public function update($request, $id)
    {
        try {
            $bloodGroupUpdate              = $this->bloodGroup->findOrfail($id);
            $bloodGroupUpdate->name        = $request->name;
            $bloodGroupUpdate->status      = $request->status;
            $bloodGroupUpdate->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $bloodGroupDestroy = $this->bloodGroup->find($id);
            $bloodGroupDestroy->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
