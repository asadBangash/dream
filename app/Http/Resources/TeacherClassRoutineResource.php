<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Academic\SubjectAssignChildren;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherClassRoutineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'class_section'     => @$this->classRoutine->class->name .'-('. @$this->classRoutine->section->name . ')',
            'class_schedule'    => Carbon::parse(@$this->timeSchedule->start_time)->format('h:i A') . ' - ' . Carbon::parse(@$this->timeSchedule->end_time)->format('h:i A'),
            'subject_name'      => @$this->subject->name .'(' . @$this->subject->code . ')' ,
            'subject_type'      => @$this->subject->type == 1 ? 'Theory' : 'Practical',
            'description'       => 'Room no: ' . @$this->classRoom->room_no,

        ];
    }
}
