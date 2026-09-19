<?php

namespace App\Repositories\StudentPanel;

use Illuminate\Support\Facades\Auth;
use Modules\VehicleTracker\Entities\DriveDutySchedule;
use Modules\VehicleTracker\Entities\DutyScheduleReport;
use Modules\VehicleTracker\Entities\EnrollmentReport;

class StudentTransportRepository
{
    public function dutySchedule($request)
    {
        try {
            $paginateSize = $request->input("paginate_size", 25);

            $dutySchedules = DriveDutySchedule::with([
                "vehicleRoute",
                "driver",
                "driver.user",
                "vehicle:id,vehicle_name,model_number,nameplate,display_name,color,vehicle_photo"
            ])
            ->whereHas("vehicleRoute.studentRouteEnrollments", function($query) {
                $query->where("student_id", @Auth::user()->student->id);
            })->paginate($paginateSize);

            return $dutySchedules;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function enrollmentReport($request)
    {
        try {
            $paginateSize = $request->input("paginate_size", 25);

            $enrollmentReports = EnrollmentReport::with([
                "student:id,first_name,last_name,image_id",
                'student.user.upload',
                "driverDutySchedule",
                "driverDutySchedule.vehicleRoute",
                "driverDutySchedule.driver:id,user_id,name,phone,emergency_contact,photo",
                "driverDutySchedule.vehicle:id,vehicle_name,model_number,nameplate,display_name,color,vehicle_photo",
                "routeStoppage"
            ])
            ->where("student_id", @Auth::user()->student->id)
            ->paginate($paginateSize);

            return $enrollmentReports;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function liveTrack()
    {
        try {
            $data = DutyScheduleReport::with([
                "dutySchedule",
                "dutySchedule.vehicleRoute",
                "dutySchedule.vehicleRoute",
                "dutySchedule.vehicleRoute.studentRouteEnrollments",
                "dutySchedule.vehicleRoute.studentRouteEnrollments.student",
                "dutySchedule.driver",
                "dutySchedule.vehicle",
            ])
            ->where("date", now()->format("Y-m-d"))
            ->whereHas("dutySchedule.vehicleRoute.studentRouteEnrollments", function ($query) {
                $query->where("student_id", @Auth::user()->student->id);
            })
            ->latest()
            ->first();

            if (!$data) {
                throw new \Exception("not found");
            }

            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function feedback($request)
    {
        try {
            $enrollmentReport = EnrollmentReport::where("type", $request->type)
            ->where("student_id", @Auth::user()->student->id)
            ->where("driver_duty_schedule_id", $request->duty_schedule_id)
            ->whereDate("time", now())
            ->first();

            if (!$enrollmentReport) {
                throw new \Exception("Data not found");
            }

            $enrollmentReport->student_feedback = $request->student_feedback;
            $enrollmentReport->save();

            return $enrollmentReport;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
