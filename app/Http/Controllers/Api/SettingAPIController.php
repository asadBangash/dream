<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;

class SettingAPIController extends Controller {

    use ApiReturnFormatTrait;

    public function pusherSettings()
    {
        $data['pusher_configs'] = [
            'PUSHER_APP_ID' => env('PUSHER_APP_ID'),
            'PUSHER_APP_KEY' => env('PUSHER_APP_KEY'),
            'PUSHER_APP_SECRET' => env('PUSHER_APP_SECRET'),
            'PUSHER_APP_CLUSTER' => env('PUSHER_APP_CLUSTER'),
        ];
        $data['event_name'] = 'my-event';
        return $this->responseWithSuccess('Pusher Configs',$data,200);
    }
}
