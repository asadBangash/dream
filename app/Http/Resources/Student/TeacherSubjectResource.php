<?php

namespace App\Http\Resources\Student;

use App\Enums\SubjectType;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherSubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (@$this->subject->type == SubjectType::THEORY) {
            $subject_type = ___('academic.theory');
        } elseif (@$this->subject->type == SubjectType::PRACTICAL) {
            $subject_type = ___('academic.practical');
        }

        return [
            'name' => @$this->subject->name,
            'code' => @$this->subject->code,
            'type' => $subject_type
        ];
    }
}
