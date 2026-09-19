<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "type"              => $this->type,
            "is_present"        => $this->is_present,
            "time"              => $this->time,
            "guardian_feedback" => $this->guardian_feedback,
            "student_feedback"  => $this->student_feedback,
            "short_note"        => $this->short_note,
            "student"           => $this->student ? [
                "id"         => $this->student->id,
                "first_name" => $this->student->first_name,
                "last_name"  => $this->student->last_name,
                "full_name"  => $this->student->full_name,
                "image"      => @globalAsset(@$this->student->user->upload->path, '40X40.webp'),
            ] : null,
            "driver_duty_schedule" => $this->driverDutySchedule ? [
                "id"          => $this->driverDutySchedule->id,
                "day_of_week" => $this->driverDutySchedule->day_of_week,
                "start_time"  => $this->driverDutySchedule->start_time,
                "end_time"    => $this->driverDutySchedule->end_time,
                "start_date"  => $this->driverDutySchedule->start_date,
                "vehicle_route" => $this->driverDutySchedule->vehicleRoute ? [
                    "id"          => $this->driverDutySchedule->vehicleRoute->id,
                    "start_point" => $this->driverDutySchedule->vehicleRoute->start_point,
                    "end_point"   => $this->driverDutySchedule->vehicleRoute->end_point,
                    "distance"    => $this->driverDutySchedule->vehicleRoute->distance,
                    "eta_time"    => $this->driverDutySchedule->vehicleRoute->eta_time,
                    "description" => $this->driverDutySchedule->vehicleRoute->description,
                ] : null,
                "driver" => $this->driverDutySchedule->driver ? [
                    "id"                => $this->driverDutySchedule->driver->id,
                    "name"              => $this->driverDutySchedule->driver->name,
                    "phone"             => $this->driverDutySchedule->driver->phone,
                    "emergency_contact" => $this->driverDutySchedule->driver->emergency_contact,
                    "photo"             => globalAsset($this->driverDutySchedule->driver->photo, '40X40.webp'),
                ] : null,
                "vehicle" => $this->driverDutySchedule->vehicle ? [
                    "id"            => $this->driverDutySchedule->vehicle->id,
                    "vehicle_name"  => $this->driverDutySchedule->vehicle->vehicle_name,
                    "model_number"  => $this->driverDutySchedule->vehicle->model_number,
                    "nameplate"     => $this->driverDutySchedule->vehicle->nameplate,
                    "display_name"  => $this->driverDutySchedule->vehicle->display_name,
                    "color"         => $this->driverDutySchedule->vehicle->color,
                    "vehicle_photo" => globalAsset($this->driverDutySchedule->vehicle->vehicle_photo, '40X40.webp'),
                ] : null,
            ] : null,
            "route_stoppage" => $this->routeStoppage ? [
                "id"          => $this->routeStoppage->id,
                "name"        => $this->routeStoppage->name,
                "latitude"    => $this->routeStoppage->latitude,
                "longitude"   => $this->routeStoppage->longitude,
                "description" => $this->routeStoppage->description,
            ] : null,
        ];
    }
}
