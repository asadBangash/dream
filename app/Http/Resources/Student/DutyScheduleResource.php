<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DutyScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "type"          => $this->checkScheduleType(),
            "day_of_week"   => $this->day_of_week,
            "start_time"    => $this->start_time,
            "end_time"      => $this->end_time,
            "start_date"    => $this->start_date,
            "created_at"    => $this->created_at,
            "vehicle_route" => $this->whenLoaded("vehicleRoute", function() {
                return [
                    "id"          => $this->vehicleRoute->id,
                    "start_point" => $this->vehicleRoute->start_point,
                    "end_point"   => $this->vehicleRoute->end_point,
                    "distance"    => $this->vehicleRoute->distance,
                    "eta_time"    => $this->vehicleRoute->eta_time,
                    "description" => $this->vehicleRoute->description,
                    "stoppages"   => $this->vehicleRoute->stoppages->map(function($stoppage) {
                        return [
                            "id"            => $stoppage->id,
                            "name"          => $stoppage->name,
                            "latitude"      => $stoppage->latitude,
                            "longitude"     => $stoppage->longitude,
                            "description"   => $stoppage->description,
                            "interval_time" => $stoppage->interval_time,
                        ];
                    })
                ];
            }),
            "students" => StudentResource::collection($this->whenLoaded("students")),
            "driver" => $this->whenLoaded("driver", function() {
                return [
                    "id"                => $this->driver->id,
                    "uuid"              => @$this->driver->user->uuid,
                    "name"              => $this->driver->name,
                    "phone"             => $this->driver->phone,
                    "emergency_contact" => $this->driver->emergency_contact,
                    "photo"             => @globalAsset($this->driver->photo, '40X40.webp'),
                ];
            }),
            "vehicle" => $this->whenLoaded("vehicle", function() {
                return [
                    "id"            => $this->vehicle->id,
                    "vehicle_name"  => $this->vehicle->vehicle_name,
                    "model_number"  => $this->vehicle->model_number,
                    "nameplate"     => $this->vehicle->nameplate,
                    "display_name"  => $this->vehicle->display_name,
                    "color"         => $this->vehicle->color,
                    "vehicle_photo" => @globalAsset($this->vehicle->vehicle_photo, '40X40.webp'),
                ];
            }),
        ];
    }

    private function checkScheduleType()
    {
        $scheduleType = "Not Started";

        $todayPickupReport = $this->todayPickupReport;

        if ($todayPickupReport) {
            $scheduleType = "pickup";

            if ($todayPickupReport->is_completed) {
                $scheduleType = "drop";
            }
        }

        // $todayDropReport = $this->todayDropReport;

        // if ($todayDropReport && $todayDropReport->is_completed) {
        //     $scheduleType = "completed";
        // }

        return $scheduleType;
    }
}
