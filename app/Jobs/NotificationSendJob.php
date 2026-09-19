<?php

namespace App\Jobs;

use App\Traits\SendNotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , SendNotificationTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $purpose , $user_ids , $data , $role ;
    public function __construct($purpose , $user_ids , $data , $role)
    {
        $this->purpose = $purpose;
        $this->user_ids = $user_ids;
        $this->data = $data;
        $this->role = $role;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->make_notification($this->purpose, $this->user_ids , $this->data , $this->role);
    }
}
