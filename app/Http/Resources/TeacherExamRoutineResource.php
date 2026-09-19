<?php

namespace App\Http\Resources;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherExamRoutineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'class_section'     => @$this->class->name .'-('. @$this->section->name . ')',
            'exam_schedule'    => Carbon::parse(@$this->timeSchedule->start_time)->format('h:i A') . ' - ' . Carbon::parse(@$this->timeSchedule->end_time)->format('h:i A'),
            'subject_name'      => @$this->subject->name .'(' . @$this->subject->code . ')' ,
            'exam_type'         => @$this->exam_type->name,
            'description'       => 'Room no: ' . @$this->classRoom->room_no,
        ];
    }
}
