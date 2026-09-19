<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends BaseModel
{
    use HasFactory;

    protected $casts = ['host' => 'array', 'reciever' => 'array', 'subject' => 'array', 'template' => 'array','shortcode' => 'array'];



    public static function getMsgFromTemplate($message_body, $data){

        $message_body = str_replace('[school_name]', @setting('application_name'), $message_body);

        $message_body = str_replace('[student_name]', @$data['student_name'], $message_body);
        $message_body = str_replace('[admission_no]', @$data['admission_no'], $message_body);
        $message_body = str_replace('[roll_no]', @$data['roll_no'], $message_body);
        $message_body = str_replace('[class]', @$data['class'], $message_body);
        $message_body = str_replace('[section]', @$data['section'], $message_body);
        $message_body = str_replace('[guardian_name]', @$data['guardian_name'], $message_body);
        $message_body = str_replace('[attendance_date]', @$data['attendance_date'], $message_body);
        $message_body = str_replace('[attendance_type]', @$data['attendance_type'], $message_body);

        $message_body = str_replace('[parent_name]', @$data['parent_name'], $message_body);
        $message_body = str_replace('[admission_date]', @$data['admission_date'], $message_body);
        $message_body = str_replace('[student_email]', @$data['student_email'], $message_body);
        $message_body = str_replace('[parent_email]', @$data['parent_email'], $message_body);

        $message_body = str_replace('[name]', @$data['receiver_name'], $message_body);
        $message_body = str_replace('[email]', @$data['receiver_email'], $message_body);
        $message_body = str_replace('[phone]', @$data['receiver_phone_number'], $message_body);



        return $message_body;
    }
}
