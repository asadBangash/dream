<?php


namespace Modules\PushNotification\Services;


use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use \Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;
use Kreait\Laravel\Firebase\Facades\Firebase;

class PushNotificationService
{

    public function SendNotification($channel, $notification_type, $id = null, $redirectUrl, $title, $body, $image = null)
    {
        try {
            // Get the Firebase Messaging instance
            $messaging = app('firebase.messaging');

            // Create the notification message
            $plainMessageBody = strip_tags($body);
            $plainMessageTitle = strip_tags($title);
            $message = CloudMessage::withTarget('topic', $channel)
                ->withNotification(Notification::create($plainMessageTitle, $plainMessageBody))
                ->withData(['url' => $redirectUrl, 'image' => $image]);

            // Send the notification to the current topic
            Log::info('Note===========================');
            Log::info($title . ' Notification has sent by channel: ' . $channel);

            $messaging->send($message);

            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }


    public function push($channel, $title, $body, $image = null, $data = ['key1' => 'value1'])
    {
        try {
            // Get the Firebase Messaging instance
            $messaging = app('firebase.messaging');

            // Create the notification message
            $plainMessageTitle = strip_tags($title);
            $plainMessageBody = strip_tags($body);

            $iconUrl = @company_fav_icon(base_settings('favicon'));

            $message = CloudMessage::withTarget('topic', $channel)
                ->withNotification(Notification::create($plainMessageTitle, $plainMessageBody, $image))
                ->withData($data)
                ->withWebPushConfig(WebPushConfig::fromArray([
                    'notification' => [
                        'icon' => $iconUrl,
                        'image' => $image,
                    ],
                ]))
                ->withAndroidConfig(AndroidConfig::fromArray([
                    'priority' => 'high',
                    'notification' => [
                        'icon' => $iconUrl,
                        'image' => $image,
                    ],
                ]));

            Log::info('========================= Notifications ===========================');
            Log::info($title . ' Notification has sent by channel: ' . $channel);

            $messaging->send($message);
            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' ' . $e->getCode());
            return false;
        }
    }


    public function browserNotification($userId, $title, $body, $image = null, $data = ['key1' => 'value1'])
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $token = $user->device_token;

            if (!$token) {
                throw new \Exception('Token not found');
            }

            $plainMessageTitle = strip_tags($title);
            $plainMessageBody = strip_tags($body);

            $iconUrl = @globalAsset(setting('favicon'), '40X40.webp');

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($plainMessageTitle, $plainMessageBody, $image)) // Title, body, and image for mobile apps
                ->withData($data)
                ->withWebPushConfig(WebPushConfig::fromArray([
                    'notification' => [
                        'icon' => $iconUrl,
                        'image' => $image,
                    ],
                ]))
                ->withAndroidConfig(AndroidConfig::fromArray([
                    'priority' => 'high',
                    'notification' => [
                        'icon' => $iconUrl,
                        'image' => $image,
                    ],
                ]));
            Log::info('Browser notification sent to user: ' . $userId);
            Firebase::messaging()->send($message);
            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

}
