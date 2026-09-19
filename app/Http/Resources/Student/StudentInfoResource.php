<?php

namespace App\Http\Resources\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        $sessionClassStudent = sessionClassStudent();

        if (Str::lower(request('slug')) == 'academic-info') {
            $data['session']                    = @$sessionClassStudent->session->name;
            $data['class']                      = @$sessionClassStudent->class->name;
            $data['section']                    = @$sessionClassStudent->section->name;
            $data['shift']                      = @$sessionClassStudent->shift->name;
            $data['roll']                       = @$sessionClassStudent->roll;
            $data['category']                   = @$this->studentCategory->name;
        } elseif (Str::lower(request('slug')) == 'student-info') {
            $data['gender']                     = @$this->gender->name;
            $data['blood_group']                = @$this->blood->name;
            $data['religion']                   = @$this->religion->name;
            $data['date_of_birth']              = date('d/M/Y', strtotime($this->dob));
        } elseif (Str::lower(request('slug')) == 'father-info') {
            $data['father_name']                = @$this->parent->father_name;
            $data['father_phone']               = @$this->parent->father_mobile;
            $data['father_profession']          = @$this->parent->father_profession;
        } elseif (Str::lower(request('slug')) == 'mother-info') {
            $data['mother_name']                = @$this->parent->mother_name;
            $data['mother_phone']               = @$this->parent->mother_mobile;
            $data['mother_profession']          = @$this->parent->mother_profession;
        } elseif (Str::lower(request('slug')) == 'local-guardian') {
            $data['guardian_name']              = @$this->parent->guardian_name;
            $data['guardian_phone']             = @$this->parent->guardian_mobile;
            $data['guardian_email']             = @$this->parent->guardian_email;
            $data['guardian_profession']        = @$this->parent->guardian_profession;
            $data['guardian_relation']          = @$this->parent->guardian_relation;
            $data['guardian_address']           = @$this->parent->guardian_address;
        } else {
            $data['student_id']                 = $this->id;
            $data['name']                       = $this->first_name . ' ' . $this->last_name;
            $data['email']                      = $this->email;
            $data['phone']                      = $this->mobile;
        }

        return $data;
    }
}
