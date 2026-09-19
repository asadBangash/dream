<?php

namespace App\Traits;

use App\Models\User;
use App\Jobs\SendMailJob;
use App\Models\SystemNotification;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

trait SendNotificationTrait
{

    public function make_notification($event, $user_ids, $data, $role_names)
    {
        try {
            $notificationData = NotificationSetting::where('event', $event)->first();

            foreach ($notificationData->reciever as $roleName => $recipientType) {
                // Super Admin Notification
                if ($recipientType == 1) {
                    foreach ($notificationData->host as $key => $type) {

                        if ($roleName == 'Super Admin') {
                            $admins = User::where('role_id',1)->get(['id', 'name', 'email', 'phone']);
                            foreach($admins as $admin){
                                $data['user_id'] = $admin->id;
                                $data['role_id'] = 1;
                                $data['receiver_name'] = $admin->name;
                                $data['receiver_email'] = $admin->email;
                                $data['receiver_phone_number'] = $admin->phone;
                                $data['admin_name'] = $data['receiver_name'];
                                if ($type == 1) {
                                    $function = 'send_' . strtolower($key);
                                    $this->$function($notificationData, $roleName, $data);
                                }
                            }
                        }
                    }
                }
                // For Super Admin End
                if ($recipientType == 1) {
                    if(!is_null($role_names)){
                        if (in_array($roleName, $role_names)) {

                            foreach ($notificationData->host as $key => $type) {

                                // For Super Admin
                                if ($roleName == 'Super admin') {
                                    $admins = User::where('role_id',1)->get(['id', 'name', 'email', 'phone']);
                                    foreach($admins as $admin){
                                        $data['user_id'] = $admin->id;
                                        $data['role_id'] = 1;
                                        $data['receiver_name'] = $admin->full_name;
                                        $data['receiver_email'] = $admin->email;
                                        $data['receiver_phone_number'] = $admin->phone_number;
                                        $data['admin_name'] = $data['receiver_name'];
                                        if ($type == 1) {
                                            $function = 'send_' . strtolower($key);
                                            $this->$function($notificationData, $roleName, $data);
                                        }
                                    }

                                }

                                // For Student
                                foreach ($user_ids as $user_id) {
                                    $userInfo = User::with(['role:id,name','student:id,parent_guardian_id,user_id','student.parent:id,user_id,father_name,guardian_email,guardian_mobile'])
                                                    ->find($user_id, ['id', 'name', 'email', 'phone', 'role_id']);

                                    if ($roleName == 'Student') {
                                        $data['user_id'] = $userInfo->id;
                                        $data['role_id'] = @$userInfo->role->id;
                                        $data['receiver_name'] = $userInfo->name;
                                        $data['receiver_email'] = $userInfo->email;
                                        $data['receiver_phone_number'] = $userInfo->phone;
                                        $data['student_name'] = $userInfo->name;
                                    }

                                    elseif ($roleName == 'Parent') {
                                        $data['role_id'] = 7;
                                        if($userInfo->role_id == 7){
                                            $data['user_id'] = $userInfo->id;
                                            $data['receiver_name'] = $userInfo->name;
                                            $data['receiver_email'] = $userInfo->email;
                                            $data['receiver_phone_number'] = $userInfo->phone;
                                            $data['guardian_name'] = $data['receiver_name'];

                                        }else{

                                            $data['user_id'] = @$userInfo->student->parent->user_id;
                                            $data['receiver_name'] = @$userInfo->student->parent->father_name;
                                            $data['receiver_email'] = @$userInfo->student->parent->guardian_email;
                                            $data['receiver_phone_number'] = @$userInfo->student->parent->guardian_mobile;

                                            $data['guardian_name'] = $data['receiver_name'];
                                            $data['student_name'] = $userInfo->full_name;
                                        }

                                    } elseif ($roleName == 'Teacher') {
                                        $data['user_id'] = $userInfo->id;
                                        $data['role_id'] = @$userInfo->role->id;
                                        $data['receiver_name'] = $userInfo->name;
                                        $data['receiver_email'] = $userInfo->email;
                                        $data['receiver_phone_number'] = $userInfo->phone;
                                    }
                                    if ($type == 1) {
                                        $function = 'send_' . strtolower($key);
                                        $this->$function($notificationData, $roleName, $data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
           Log::info($e);
        }
    }

    public function send_email($notificationData, $role, $data)
    {

        if ($notificationData->reciever[$role] != 1) {
            return;
        }

        $receiver_name = gv($data, 'receiver_name');
        $reciver_email = gv($data, 'receiver_email');

        if (!$reciver_email) {
            return;
        }

        $mail_driver = setting('mail_drive');
        $mail_host = setting('mail_host');
        $mail_address = setting('mail_address');
        $from_name = setting('from_name');
        $mail_username = setting('mail_username');
        $mail_password = setting('mail_password');
        $mail_port = setting('mail_port');
        $encryption = setting('encryption');

        $setting = $mail_driver && $mail_host && $mail_address && $from_name && $mail_username  && $mail_password && $mail_port && $encryption;
        if (!$setting) {
            return;
        }

        $subject = $notificationData->subject[$role];
        $templete = $notificationData->template[$role]['Email'];
        $body = NotificationSetting::getMsgFromTemplate($templete, $data);

        if(!$templete){
            return;
        }

        try {

            $emailData['driver'] = $mail_driver;
            $emailData['reciver_email'] = $reciver_email;
            $emailData['receiver_name'] = $receiver_name;
            $emailData['sender_name'] = $from_name;
            $emailData['sender_email'] = $mail_address;
            $emailData['subject'] = $subject;

            if(env('NOTIFICATION_JOB') == 'queue'){
                dispatch(new SendMailJob($body, $emailData));
            }else{
                dispatch(new SendMailJob($body, $emailData))->handle();
            }

        } catch (\Exception $e) {
            Log::info($e);
            dd($e);
        }
    }

    public function send_sms($notificationData, $role, $data)
    {

        if ($notificationData->reciever[$role] != 1) {
            return;
        }

        $reciver_number = $data['receiver_phone_number'];

        if (!$reciver_number) {
            return;
        }

        $templete = $notificationData->template[$role]['SMS'];
        $body = NotificationSetting::getMsgFromTemplate($templete, $data);

        try {
            @send_message_twillo($body,$reciver_number);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    public function send_web($notificationData, $role, $data)
    {
        Log::info("User Id:::::". gv($data, 'user_id'));
        if ($notificationData->reciever[$role] != 1) {
            return;
        }

        $subject = $notificationData->subject[$role];
        $templete = $notificationData->template[$role]['Web'];
        $body = NotificationSetting::getMsgFromTemplate($templete, $data);

        try {
            $notification = new SystemNotification();
            $notification->title = $subject;
            $notification->message = $body;
            $notification->reciver_id = gv($data, 'user_id');
            $notification->url = gv($data, 'url', NULL);
            $notification->save();
        } catch (\Throwable $th) {
            Log::info('Web Notification store::'. $th);
         //   Log::info($th->getMessage());
        }


    }

    public function send_app($notificationData, $role, $data)
    {
            if ($notificationData->reciever[$role] != 1) {
                return;
            }
            @send_flutter_notification('','');

            $templete = $notificationData->template[$role]['App'];
            $message = NotificationSetting::getMsgFromTemplate($templete, $data);

        try {

            @send_message_twillo('Student Attendance',$message);

        } catch (\Exception $e) {
            Log::info($e);
        }
    }
}
