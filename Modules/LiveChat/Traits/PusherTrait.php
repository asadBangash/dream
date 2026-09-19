<?php
namespace Modules\LiveChat\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

trait PusherTrait
{

    function sendMessage($message)
    {
        try {
            $app_id = env('PUSHER_APP_ID');
            $app_key = env('PUSHER_APP_KEY');
            $app_secret = env('PUSHER_APP_SECRET');
            $app_cluster = env('PUSHER_APP_CLUSTER');

            $pusher = new Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);

            $channelName = 'receiver_channel' . $message->receiver_id;

            $data= [
              'message' => $message->message,
              'receiver_id' => $message->receiver_id,
              'sender_id' => $message->sender_id,
              'channel_name' => $channelName,
              'created_at' => Carbon::parse($message->created_at)->diffForHumans(),
            ];

            $pusher->trigger($channelName, 'my-event', $data);

            Log::info($data);

            return [
                'status' => true,
                'data' => $data,
                'message' => 'Message sent successfully',
            ];
        } catch (\Throwable $th) {
            Log::error($th);
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
