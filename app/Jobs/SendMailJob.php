<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $body;
    protected $email_config = [];

    public function __construct($body , $email_config)
    {
        $this->body = $body;
        $this->email_config = $email_config;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info($this->body);
            Log::info($this->email_config);
            Mail::send('backend.settings.email_body_content', ['body' => $this->body], function ($message) {
                $message->to($this->email_config['reciver_email'], $this->email_config['receiver_name'])->subject($this->email_config['subject']);
                $message->from($this->email_config['sender_email'], $this->email_config['sender_name']);
            });
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }


    }
}
