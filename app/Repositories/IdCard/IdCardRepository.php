<?php

namespace App\Repositories\IdCard;

use App\Models\IdCard;
use App\Models\Homework;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\IdCard\IdCardInterface;
use App\Models\StudentInfo\SessionClassStudent;

class IdCardRepository implements IdCardInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(IdCard $model)
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

            $row                     = new $this->model;
            $row->title              = $request->title;
            $row->expired_date       = $request->expired_date;
            $row->frontside_bg_image       = $this->UploadImageCreate($request->frontside_bg_image, 'backend/uploads/idcards');
            $row->backside_bg_image        = $this->UploadImageCreate($request->backside_bg_image, 'backend/uploads/idcards');

            $row->signature     = $this->UploadImageCreate($request->signature, 'backend/uploads/idcards');
            $row->qr_code       = $this->UploadImageCreate($request->qr_code, 'backend/uploads/idcards');

            $row->backside_description    = $request->backside_description;

            $row->admission_no            = $request->admission_no ==  'on' ? true:false;
            $row->roll_no                 = $request->roll_no ==  'on' ? true:false;
            $row->student_name            = $request->student_name ==  'on' ? true:false;
            $row->class_name              = $request->class_name ==  'on' ? true:false;
            $row->section_name            = $request->section_name ==  'on' ? true:false;
            $row->blood_group             = $request->blood_group ==  'on' ? true:false;
            $row->dob                     = $request->dob ==  'on' ? true:false;
            
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
        DB::beginTransaction();
        try {
            $row                     = $this->model->find($id);
            $row->title              = $request->title;
            $row->expired_date       = $request->expired_date;
            $row->frontside_bg_image       = $this->UploadImageUpdate($request->frontside_bg_image, 'backend/uploads/idcards', $row->frontside_bg_image);
            $row->backside_bg_image        = $this->UploadImageUpdate($request->backside_bg_image, 'backend/uploads/idcards', $row->backside_bg_image);

            $row->signature     = $this->UploadImageUpdate($request->signature, 'backend/uploads/idcards', $row->signature);
            $row->qr_code       = $this->UploadImageUpdate($request->qr_code, 'backend/uploads/idcards', $row->qr_code);

            $row->backside_description    = $request->backside_description;

            $row->admission_no            = $request->admission_no ==  'on' ? true:false;
            $row->roll_no                 = $request->roll_no ==  'on' ? true:false;
            $row->student_name            = $request->student_name ==  'on' ? true:false;
            $row->class_name              = $request->class_name ==  'on' ? true:false;
            $row->section_name            = $request->section_name ==  'on' ? true:false;
            $row->blood_group             = $request->blood_group ==  'on' ? true:false;
            $row->dob                     = $request->dob ==  'on' ? true:false;
            
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
            $this->UploadImageDelete($row->frontside_bg_image);
            $this->UploadImageDelete($row->backside_bg_image);
            $this->UploadImageDelete($row->signature);
            $this->UploadImageDelete($row->qr_code);
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function generateSearch($request)
    {

        try {

            $data['students'] =  SessionClassStudent::where('session_id', setting('session'))
                                                    ->where('classes_id', $request->class)
                                                    ->where('section_id', $request->section)
                                                    ->when($request->student != '', function($query) use ($request)  {
                                                        return $query->where('student_id', $request->student);
                                                    })
                                                    ->get();
            $data['idcard'] = $this->model->find($request->id_card);      
            
            return $this->responseWithSuccess('', $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }                 
                                                
    }
}
