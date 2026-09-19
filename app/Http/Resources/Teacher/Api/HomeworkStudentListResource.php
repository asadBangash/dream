<?php

namespace App\Http\Resources\Teacher\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkStudentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id,
            'student_name' => $this->student->full_name ?? null,
            'student_roll' => $this->student->roll_no ?? null,
            'admission_no' => $this->student->admission_no ?? null,
            'homework_submitted' => $this->homeworkStudent ? true : false,
            'marks' => $this->homeworkStudent
                    ? [
                        'marks' => $this->homeworkStudent->marks ?? null,
                        'submitted_file_path' => globalAsset($this->homeworkStudent->homeworkUpload) ?? null,
                    ]
                    : null,
        ];
    }


}
