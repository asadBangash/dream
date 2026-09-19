<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveTrackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "date"          => $this->date,
            "type"          => $this->type,
            "is_completed"  => $this->is_completed,
            "created_at"    => $this->created_at,
            "duty_schedule" => new DutyScheduleResource($this->whenLoaded("dutySchedule")),
        ];
    }
}
