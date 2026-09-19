<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\StudentAbsentNotification;
use App\Jobs\StudentAttendanceNotificationJOb;

class AttendaceNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Student Attendance Absent Notification Send To Parent';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentMinute = now()->format('H:i');
        $setting = StudentAbsentNotification::first();

        if ($setting && $setting->sending_time) {
            $sending_times = json_decode($setting->sending_time, true);
            // Check if the current time matches any of the sending times
            if (in_array($currentMinute, $sending_times)) {
                // Execute the queue:work command
                Artisan::call('queue:work --once');

            }
        }
        return Command::SUCCESS;
    }
}
