<?php

namespace App\Http\Resources\Student;

use Carbon\Carbon;
use App\Models\Academic\SubjectAssignChildren;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassRoutineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sessionClassStudent    = sessionClassStudent();

        $subjectAssignChildren  = SubjectAssignChildren::query()
                                ->whereHas('subjectAssign', function ($q) use ($sessionClassStudent) {
                                    $q->active()
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id);
                                })
                                ->whereHas('subject', fn ($q) => $q->active()->where('id', $this->subject_id))
                                ->first();

        return [
            'start_time'        => Carbon::parse(@$this->timeSchedule->start_time)->format('h:i A'),
            'end_time'          => Carbon::parse(@$this->timeSchedule->end_time)->format('h:i A'),
            'subject_name'      => @$this->subject->name,
            'description'       => 'Room no: ' . @$this->classRoom->room_no,
            'teacher' => [
                'id'            => $subjectAssignChildren->staff_id,
                'name'          => @$subjectAssignChildren->teacher->first_name . ' ' . @$subjectAssignChildren->teacher->last_name,
                'avatar'        => @globalAsset(@$subjectAssignChildren->teacher->upload->path, '40X40.webp'),
            ]
        ];
    }
}
