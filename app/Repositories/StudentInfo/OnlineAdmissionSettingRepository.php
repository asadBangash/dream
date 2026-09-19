<?php

namespace App\Repositories\StudentInfo;

use Exception;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\WebsiteSetup\OnlineAdmissionSetting;
use App\Models\StudentInfo\OnlineAdmissionFeesAssign;

class OnlineAdmissionSettingRepository {

    protected $model;
    protected $online_ad_fees ;

    use ReturnFormatTrait;

    public function __construct(OnlineAdmissionSetting $model , OnlineAdmissionFeesAssign $online_ad_fees)
    {
         $this->model = $model;
         $this->online_ad_fees = $online_ad_fees;
    }


    public function getAllByType($type)
    {
        return $this->model->where('type',$type)->whereNotIn('field',['admission_payment','admission_payment_info'])->get();
    }


    public function getOneByFied($field)
    {
        return $this->model->where('field',$field)->first();
    }

    public function getAllFeesPaginate($perPage = 15)
    {
        return OnlineAdmissionFeesAssign::paginate($perPage);
    }

    public function getAllFees()
    {
        return OnlineAdmissionFeesAssign::all();
    }

    public function onlineFeesAssignShow($id){
        return $this->online_ad_fees->findOrFail($id);
    }

    public function getIsShowByType($type)
    {
        return $this->model->where('is_show',1)->where('type',$type)->get();
    }


    public function update($request)
    {

        try{
          if($request->type == "fees_setting"){
                $fees_setting = $this->model->where('field','admission_payment_info')->first();
                if($fees_setting){
                    $fees_setting->field_value = $request->field_value['admission_payment_info'];
                    $fees_setting->save();
                }

            $admission_payment = $this->getOneByFied('admission_payment');

            if($admission_payment){
                $admission_payment->is_show = $request->online_admission_fees ?? 0;
                $admission_payment->is_required = $request->online_admission_fees ?? 0;
                $admission_payment->save();
            }
          }


          else{

            foreach($request->id ?? [] as $key => $id) {
                $this->model->where('id', $id)->update([
                    'is_show' => $request->visibility[$key],
                    'is_required' => $request->required[$key],
                ]);
            }
          }


            return $this->responseWithSuccess(___('alert.created_successfully'), []);

        }catch(\Exception $e){
            dd($e);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function feesStore($request)
    {
        try{
                $assign = new $this->online_ad_fees;
                $assign->fees_group_id = $request->fees_group ;
                $assign->class_id = $request->class;
                $assign->section_id = $request->section;
                $assign->description = $request->description;
                $assign->session_id = setting('session');
                $assign->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        }catch(\Exception $e){
            dd($e);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function feesUpdate($request)
    {
        try{
                $assign =  $this->onlineFeesAssignShow($request->id);
                $assign->fees_group_id = $request->fees_group ;
                $assign->class_id = $request->class;
                $assign->section_id = $request->section;
                $assign->save();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        }catch(\Exception $e){
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->online_ad_fees->find($id);
            $row->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
