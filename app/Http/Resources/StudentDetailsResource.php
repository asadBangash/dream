<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->first_name . ' ' . $this->last_name,
            'admission_no'   => $this->roll_no,
            'roll_no'   => $this->roll_no,
            'email'     => $this->email,
            'mobile'    => $this->mobile,
            'session'   => @$this->session_class_student->session->name,
            'class'     => @$this->session_class_student->class->name,
            'section'   => @$this->session_class_student->section->name,
            'shift'   => @$this->session_class_student->shift->name,
            'date_of_birth'   => @$this->dob,
            'religion'   => @$this->religion->name,
            'gender'   => @$this->gender->name,
            'blood'   => @$this->blood->name,
            'admission_date'   => @$this->admission_date,
            'parent_info'   => [
                "father_name" => @$this->parent->father_name,
                "father_mobile" =>  @$this->parent->father_mobile,
                "father_profession" =>  @$this->parent->father_profession,

                "mother_name" => @$this->parent->mother_name,
                "mother_mobile" =>  @$this->parent->mother_mobile,
                "mother_profession" =>  @$this->parent->mother_profession,

                'guardian_name' => @$this->parent->guardian_name,
                'guardian_mobile' => @$this->parent->guardian_mobile,
                'guardian_email' => @$this->parent->guardian_email,
                'guardian_profession' => @$this->parent->guardian_profession,
            ],
            'avatar'    => @globalAsset(@$this->user->upload->path, '40X40.webp'),
        ];


    }
}
