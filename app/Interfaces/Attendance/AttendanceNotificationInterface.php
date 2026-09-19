<?php

namespace App\Interfaces\Attendance;

interface AttendanceNotificationInterface
{

    public function setting();

    public function update($request);
}
