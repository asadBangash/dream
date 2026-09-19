<?php

namespace App\Jobs;

use App\Models\StudentAbsentNotification;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StudentAttendanceNotificationJOb implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $student;
    protected $attendace;

    public function __construct($student , $attendace)
    {
        $this->student = $student;
        $this->attendace = $attendace;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {

            $session = SessionClassStudent::where('student_id',$this->student->id)->with(['class:id,name','section:id,name'])
                                            ->where('session_id', $this->attendace->session_id)
                                            ->first();

            $data['student_name'] = @$this->student->first_name;
            $data['admission_no'] = @$this->student->admission_no;
            $data['roll_no'] = @$this->student->roll_no;
            $data['class'] = @$session->class->name;
            $data['section'] = @$session->section->name;
            $data['guardian_name'] = $this->student->parent ? ($this->student->parent->father_name ?  $this->student->parent->father_name : $this->student->parent->guardian_name) : '';
            $data['attendance_date'] = dateFormat($this->attendace->date);
            $data['attendance_type'] = getAttendanceType($this->attendace->attendance);
            $data['school_name'] = 'school name';
            $data['parent_user_id'] = @$this->student->parent->user->id;

            $absent_noti_setting = StudentAbsentNotification::where('active_status',1)->first();

            if($absent_noti_setting){

            $sms_body = $absent_noti_setting->notification_message;

                $message_body = str_replace('[student_name]', @$data['student_name'], $sms_body);
                $message_body = str_replace('[admission_no]', @$data['admission_no'], $message_body);
                $message_body = str_replace('[roll_no]', @$data['roll_no'], $message_body);
                $message_body = str_replace('[class]', @$data['class'], $message_body);
                $message_body = str_replace('[section]', @$data['section'], $message_body);
                $message_body = str_replace('[guardian_name]', @$data['guardian_name'], $message_body);
                $message_body = str_replace('[attendance_date]', @$data['attendance_date'], $message_body);
                $message_body = str_replace('[attendance_type]', @$data['attendance_type'], $message_body);
                $message_body = str_replace('[school_name]', @$data['school_name'], $message_body);

                @send_web_notification('New Attendace Taken',$message_body, $data['parent_user_id']);

    }
        } catch (\Throwable $th) {
            Log::error('Notification Job Error '.$th->getMessage());
        }

    }
}
