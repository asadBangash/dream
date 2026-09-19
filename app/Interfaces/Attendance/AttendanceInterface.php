<?php

namespace App\Interfaces\Attendance;

interface AttendanceInterface
{

    public function attendance();

    public function store($request);

    public function searchStudents($request);

}
