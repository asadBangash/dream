<?php

namespace App\Repositories\SmsMailLog;

use App\Models\User;
use App\Enums\UserType;
use App\Models\Session;
use Twilio\Rest\Client;
use App\Models\SmsMailLog;
use App\Enums\TemplateType;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\Student;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\SmsMailLog\SmsMailLogInterface;


class SmsMailLogRepository implements SmsMailLogInterface
{
    use ReturnFormatTrait, CommonHelperTrait;

    private $model;

    public function __construct(SmsMailLog $model)
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

        // $sid   = config('services.twilio.account_sid');
        // $token = config('services.twilio.auth_token');

        // $client = new Client($sid, $token);

        // $to = '+8801810038868';

        // $client->messages->create(
        //     $to,
        //     [
        //         'from' => '+14422426457',
        //         'body' => 'hello world',
        //     ]
        // );


        // dd('success');


        



        // DB::beginTransaction();
        // try {


            $role_ids    = explode(',', $request->role_ids);
            $users       = explode(',', $request->users);
            $section_ids = explode(',', $request->section_ids);

            $mobiles = [];
            if($request->user_type == UserType::ROLE) { 

                $mobiles = User::whereIn('role_id', $role_ids)->pluck('phone')->toArray();

            } elseif ($request->user_type == UserType::INDIVIDUAL) {

                $mobiles = User::whereIn('id', $users)->pluck('phone')->toArray();

            } elseif ($request->user_type == UserType::CLASSSECTION) {
                
                $students = SessionClassStudent::where('classes_id', $request->class_id)->whereIn('section_id', $section_ids)->where('session_id', setting('session'))->pluck('student_id');
                $mobiles  = Student::whereIn('id', $students)->pluck('mobile')->toArray();
            }


            
            
            // if($request->type == TemplateType::SMS) {

            //     $mobiles = array_map(function($value ) use ($request) {
            //         if($value != '') {
            //             return '+88'.$value;
            //         }
            //     }, $mobiles);
    
            //     $mobiles = implode(", ", $mobiles);

            //     $sid   = Setting('twilio_account_sid');
            //     $token = Setting('twilio_auth_token');
            //     $from  = Setting('twilio_phone_number');

            //     $client = new Client($sid, $token);


            //     $client->messages->create(
            //         $mobiles,
            //         [
            //             'from' => $from,
            //             'body' => $request->sms_description,
            //         ]
            //     );
            // }

            $row                    = new $this->model;
            $row->title             = $request->title;
            $row->type              = $request->type;

            if($request->type == TemplateType::SMS) {

                $row->sms_description      = $request->sms_description;

            } else {

                $row->mail_description     = $request->mail_description;
                $row->attachment           = $this->UploadImageCreate($request->attachment, 'backend/uploads/communication');
            }

            $row->user_type             = $request->user_type;

            if($request->user_type == UserType::ROLE) { 

                $row->role_ids             = $role_ids;

            } elseif ($request->user_type == UserType::INDIVIDUAL) {

                $row->individual_user_ids             = $users;

            } elseif ($request->user_type == UserType::CLASSSECTION) {
                $row->class_id             = $request->class_id;
                $row->section_ids          = $section_ids;

            }

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
