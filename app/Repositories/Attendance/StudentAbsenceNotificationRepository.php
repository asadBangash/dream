<?php

namespace App\Repositories\Attendance;

use App\Traits\ReturnFormatTrait;
use App\Models\StudentAbsentNotification;
use App\Interfaces\Attendance\AttendanceNotificationInterface;


class StudentAbsenceNotificationRepository implements AttendanceNotificationInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(StudentAbsentNotification $model)
    {
        $this->model  = $model;
    }

    public function setting(){
        
        return $this->model->first();
        
    }

    public function update($request){
        $send_times = [];
        foreach($request->shift_ids as $key => $shift){
            $send_times[$shift] = $request->sending_times[$key];
        }
        $setting =  $this->model->first();
        $setting->notify_student = $request->notify_student ?? 0 ;
        $setting->notify_gurdian = $request->notify_gurdian  ?? 0;
        $setting->sending_time =  $send_times ;
        $setting->active_status = $request->active_status ;
        $setting->save();
        return $this->responseWithSuccess(___('alert.submitted_successfully'), []);
    }


}
