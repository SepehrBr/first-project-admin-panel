<?php

namespace App\Notifications;

use App\Notifications\Channels\GhasedakChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActiveCodeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $code, public $phoneNumber)
    {
        $this->code = $code;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [GhasedakChannel::class];
    }

    public function toGhasedakSms($notifiable)
    {
        return [
            'text' => "code: $this->code",
            'phone' => $this->phoneNumber
        ];
    }

}
