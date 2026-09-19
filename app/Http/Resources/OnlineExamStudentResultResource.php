<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlineExamStudentResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
        public function toArray($request)
        {
            return $this->examStudents->map(function ($result) {
                $obtained_marks = $this->studentAnswer->where('student_id', $result->student_id)->first();
                return [
                    'student_name'    => optional($result->student)->full_name,
                    'admission_no'    => optional($result->student)->admission_no,
                    'roll_no'         => optional($result->student)->roll_no,
                    'obtained_marks'  => $obtained_marks ? $obtained_marks->result : null,
                ];
            })->values();
        }
}
