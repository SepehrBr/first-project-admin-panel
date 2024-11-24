<?php namespace App\Notifications\Channels;
      use Ghasedak\Exceptions\ApiException;
      use Ghasedak\Exceptions\HttpException;
      use Ghasedak\GhasedakApi;
      use Illuminate\Notifications\Notification;

class GhasedakChannel
{
    public function send( $notifiable, Notification $notification)
    {
        // text template
        if (!method_exists($notification, 'toGhasedakSms')) {
            throw new \Exception("toGhasedakSms doesnt exist");
        }

        try {
            $message = $notification->toGhasedakSms($notifiable)['text'];
            $receptor = $notification->toGhasedakSms($notifiable)['phone'];
            $apiKey = config('services.ghasedak.key');
            $lineNumber = "10008566";
            $api = new GhasedakApi($apiKey);
            $api->SendSimple($receptor, $message,$lineNumber);
        }
            catch(ApiException $e){
                throw $e;
        }
            catch(HttpException $e){
                throw $e;
        }
    }
}
