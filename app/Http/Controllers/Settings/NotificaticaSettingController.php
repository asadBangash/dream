<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\SystemNotification;
use App\Models\NotificationSetting;
use App\Http\Controllers\Controller;
use App\Repositories\SystemNotificationRepository;

class NotificaticaSettingController extends Controller
{

    protected $system_notification_repo;


    public function __construct(SystemNotificationRepository $system_notification_repo)
    {
        $this->system_notification_repo = $system_notification_repo;
    }

    public function notificationSettings(){
        $data = [];
        $data['pt'] = ___('settings.notification_setting');
        $data['notificationSettings'] =  $this->system_notification_repo->setting();
        return view('backend.settings.notification_setting',$data);
    }


    public function notificationEventModal($id , $key){

        $modal = $this->system_notification_repo->showSetting($id);
        $data = [];
        if($modal){
            $data['id'] = $id;
            $data['key'] = $key;
            $data['shortcode'] = $modal->shortcode[$key];
            $data['subject'] = $modal->subject[$key];
            $data['emailBody'] = $modal->template[$key]['Email'];
            $data['smsBody'] = $modal->template[$key]['SMS'];
            $data['appBody'] = $modal->template[$key]['App'];
            $data['webBody'] = $modal->template[$key]['Web'];
        }
        return view('backend.settings.notification_setting_modal',$data);
    }

    public function viewNotification($id){

         $result = $this->system_notification_repo->readNotification($id);
         if($result && $result->url){
            return redirect($result->url);
         }

         return redirect()->back()->with('success', 'Notification Viewed');
    }


    public function updateNotificationSetting(Request $request){

        $result = $this->system_notification_repo->settingUpdate($request);
    }
}
