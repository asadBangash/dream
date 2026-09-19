<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StudentAttendanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $student;
    protected $attendace;

     
    public function __construct($student , $attendace)
    {
        $this->student = $student;
        $this->attendace = $attendace;
    }


    public function send_notification(){
        Log::info(@$this->student->name);
        Log::info(@$this->attendace->attendance);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::info("One::" .$notifiable);
        Log::info("Two::" .$this->student->name);
        Log::info("Three::" .$this->attendace->attendance);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
