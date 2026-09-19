<?php

namespace App\Repositories\ParentPanel;

use Illuminate\Support\Facades\Auth;
use Modules\VehicleTracker\Entities\DriveDutySchedule;
use Modules\VehicleTracker\Entities\DutyScheduleReport;
use Modules\VehicleTracker\Entities\EnrollmentReport;

class ParentTransportRepository
{
    public function dutySchedule($request)
    {
        try {
            $paginateSize = $request->input("paginate_size", 25);

            $childrenIds = @Auth::user()->parent->children->pluck("id") ?? [];

            $dutySchedules = DriveDutySchedule::with([
                "vehicleRoute",
                "vehicleRoute.stoppages",
                "students",
                "students.pickupReport:id,type,student_id,time",
                "students.dropReport:id,type,student_id,time",
                "driver",
                "driver.user",
                "vehicle:id,vehicle_name,model_number,nameplate,display_name,color,vehicle_photo",
            ])
            ->whereHas("vehicleRoute.studentRouteEnrollments", function($query) use ($childrenIds) {
                $query->whereIn("student_id", $childrenIds);
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
            $childrenIds  = @Auth::user()->parent->children->pluck("id") ?? [];

            $enrollmentReports = EnrollmentReport::with([
                "student:id,first_name,last_name,image_id",
                'student.user.upload',
                "driverDutySchedule",
                "driverDutySchedule.vehicleRoute",
                "driverDutySchedule.driver:id,user_id,name,phone,emergency_contact,photo",
                "driverDutySchedule.vehicle:id,vehicle_name,model_number,nameplate,display_name,color,vehicle_photo",
                "routeStoppage"
            ])
            ->whereIn("student_id", $childrenIds)
            ->paginate($paginateSize);

            return $enrollmentReports;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function liveTrack()
    {
        try {
            $childrenIds = @Auth::user()->parent->children->pluck("id") ?? [];

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
            ->whereHas("dutySchedule.vehicleRoute.studentRouteEnrollments", function ($query) use ($childrenIds) {
                $query->whereIn("student_id", $childrenIds);
            })
            ->latest()
            ->first();

            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function feedback($request)
    {
        try {
            $enrollmentReport = EnrollmentReport::where("type", $request->type)
            ->where("student_id", $request->student_id)
            ->where("driver_duty_schedule_id", $request->duty_schedule_id)
            ->whereDate("time", now())
            ->first();

            if (!$enrollmentReport) {
                throw new \Exception("Data not found");
            }

            $enrollmentReport->guardian_feedback = $request->guardian_feedback;
            $enrollmentReport->save();

            return $enrollmentReport;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
