<?php

namespace App\Repositories;

use App\Enums\Settings;
use App\Models\Religion;
use App\Models\ReligonTranslate;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReligionInterface;

class ReligionRepository implements ReligionInterface
{
    use ReturnFormatTrait;
    private $religion;

    private $religionTrns;

    public function __construct(Religion $religion , ReligonTranslate $religionTrns)
    {
        $this->religion = $religion;
        $this->religionTrns = $religionTrns;
    }

    public function all()
    {
        return $this->religion->active()->get();
    }

    public function getAll()
    {
        return $this->religion->latest()->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        try {
            $religionStore              = new $this->religion;
            $religionStore->name        = $request->name;
            $religionStore->status      = $request->status;
            $religionStore->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->religion->find($id);
    }

    public function update($request, $id)
    {
        try {
            $religionUpdate              = $this->religion->findOrfail($id);
            $religionUpdate->name        = $request->name;
            $religionUpdate->status      = $request->status;
            $religionUpdate->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $religionDestroy = $this->religion->find($id);
            $religionDestroy->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function translates($id){

        return $this->religionTrns->where('religion_id',$id)->get()->groupBy('locale');
    }

    public function translateUpdate($request, $id){
        DB::beginTransaction();
        try {
            $delete_old = $this->religionTrns->where('religion_id',$id)->delete();
            $religion = $this->show($id);

            foreach($request->name as $key => $name){
                $row                   = new $this->religionTrns;
                $row->religion_id        = $id ;
                $row->locale           = $key ;
                $row->name             = $name;
                $row->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
