<?php

namespace App\Repositories\SmsMailTemplate;

use App\Models\Session;
use App\Enums\TemplateType;
use App\Models\SmsMailTemplate;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\SmsMailTemplate\SmsMailTemplateInterface;

class SmsMailTemplateRepository implements SmsMailTemplateInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(SmsMailTemplate $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderByDesc('id')->get();
    }

    public function smsAll()
    {
        return $this->model->orderByDesc('id')->where('type', TemplateType::SMS)->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->orderByDesc('id')->paginate(10);
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
        DB::beginTransaction();
        try {

            $row                    = new $this->model;
            $row->title             = $request->title;
            $row->type              = $request->type;

            if($request->type == TemplateType::SMS) {

                $row->sms_description      = $request->sms_description;

            } else {

                $row->mail_description     = $request->mail_description;
                $row->attachment           = $this->UploadImageCreate($request->attachment, 'backend/uploads/communication');
            }

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
            $row                    = $this->model->find($id);
            $row->title             = $request->title;
            $row->type              = $request->type;

            if($request->type == TemplateType::SMS) {

                $row->sms_description          = $request->descrsms_descriptioniption;

            } else {

                $row->mail_description     = $request->mail_description;
                $row->attachment           = $this->UploadImageCreate($request->attachment, 'backend/uploads/communication', $row->attachment);
            }
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
            $this->UploadImageDelete($row->attachment);
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

}
