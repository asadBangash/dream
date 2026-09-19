<?php

namespace App\Http\Resources\Student;

use Illuminate\Support\Facades\Auth;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    public function toArray($request)
    {
        if (Auth::user()->role_id == 6) {
            $sessionClassStudent = sessionClassStudent();
        }

        return [
            'student_id'        => $this->id,
            'avatar'            => @globalAsset($this->upload->path, '40X40.webp'),
            'name'              => Auth::user()->name,
            'class'             => @$sessionClassStudent->class->name,
            'section'           => @$sessionClassStudent->section->name,
            'roll'              => @$sessionClassStudent->roll,
            'blood_group'       => @$this->blood->name,
            'gender'            => @$this->gender->name,
            'date_of_birth'     => date('d/m/Y', strtotime($this->dob)),
            'religion'          => @$this->religion->name
        ];
    }
}
