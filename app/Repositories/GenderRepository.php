<?php

namespace App\Repositories;

use App\Models\Gender;
use App\Enums\Settings;
use App\Models\GenderTranslate;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Interfaces\GenderInterface;

class GenderRepository implements GenderInterface
{
    use ReturnFormatTrait;
    private $gender;
    private $genderTrns;

    public function __construct(Gender $gender , GenderTranslate $genderTrns)
    {
        $this->gender = $gender;
        $this->genderTrns = $genderTrns;
    }

    public function all()
    {
        return $this->gender->active()->get();
    }

    public function getAll()
    {
        return $this->gender->latest()->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        try {
            $genderStore              = new $this->gender;
            $genderStore->name        = $request->name;
            $genderStore->status      = $request->status;
            $genderStore->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->gender->find($id);
    }

    public function update($request, $id)
    {
        try {
            $genderUpdate              = $this->gender->findOrfail($id);
            $genderUpdate->name        = $request->name;
            $genderUpdate->status      = $request->status;
            $genderUpdate->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $genderDestroy = $this->gender->find($id);
            $genderDestroy->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function translates($id){

        return $this->genderTrns->where('gender_id',$id)->get()->groupBy('locale');
    }

    public function translateUpdate($request, $id){
        DB::beginTransaction();
        try {
            $delete_old = $this->genderTrns->where('gender_id',$id)->delete();
            $gender = $this->show($id);

            foreach($request->name as $key => $name){
                $row                   = new $this->genderTrns;
                $row->gender_id        = $id ;
                $row->locale           = $key ;
                $row->name             = $name;
                $row->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
