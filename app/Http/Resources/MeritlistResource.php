<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeritlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'merit_position' => $this->position,
            'student_name' => $this->student->full_name,
            'admission_no' => $this->student->admission_no,
            'class_sec' => @$this->class->name . '-' . @$this->section->name,
            'result' => $this->result,
            'point' => $this->grade_point,
            'grade' => $this->grade_name,
            'total_mark' => $this->total_marks

        ];
    }
}
