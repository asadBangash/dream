<?php

namespace App\Repositories\Certificate;

use App\Models\Session;
use App\Models\Homework;
use App\Models\Certificate;
use App\Models\HomeworkStudent;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\Certificate\CertificateInterface;

class CertificateRepository implements CertificateInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(Certificate $model)
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
            $row->top_text           = $request->top_text;
            $row->description        = $request->description;
            $row->bg_image           = $this->UploadImageCreate($request->bg_image, 'backend/uploads/certificates');

            $row->bottom_left_text             = $request->bottom_left_text;
            $row->bottom_left_signature        = $this->UploadImageCreate($request->bottom_left_signature, 'backend/uploads/certificates');

            $row->bottom_right_text             = $request->bottom_right_text;
            $row->bottom_right_signature        = $this->UploadImageCreate($request->bottom_right_signature, 'backend/uploads/certificates');

            $row->logo             = $request->logo ==  'on' ? true:false;
            $row->name             = $request->name ==  'on' ? true:false;
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
            $row->top_text           = $request->top_text;
            $row->description        = $request->description;
            $row->bg_image           = $this->UploadImageCreate($request->bg_image, 'backend/uploads/certificates', $row->bg_image);

            $row->bottom_left_text             = $request->bottom_left_text;
            $row->bottom_left_signature        = $this->UploadImageCreate($request->bottom_left_signature, 'backend/uploads/certificates', $row->bottom_left_signature);

            $row->bottom_right_text             = $request->bottom_right_text;
            $row->bottom_right_signature        = $this->UploadImageCreate($request->bottom_right_signature, 'backend/uploads/certificates', $row->bottom_right_signature);

            $row->logo             = $request->logo ==  'on' ? true:false;
            $row->name             = $request->name ==  'on' ? true:false;
            
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
            $this->UploadImageDelete($row->bg_image);
            $this->UploadImageDelete($row->bottom_left_signature);
            $this->UploadImageDelete($row->bottom_right_signature);
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
            $data['certificate'] = $this->model->find($request->certificate);
            $data['session']     = Session::find(setting('session'))->name;
            
            return $this->responseWithSuccess('', $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }                 
                                                
    }

}
