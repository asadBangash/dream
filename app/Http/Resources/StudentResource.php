<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id'        => $this->id,
            'name'      => $this->first_name . ' ' . $this->last_name,
            'roll_no'   => $this->roll_no,
            'gender'     =>@$this->gender->name,
            'mobile'    => $this->mobile,
            'session'   => @$this->session_class_student->session->name,
            'class'     => @$this->session_class_student->class->name,
            'section'   => @$this->session_class_student->section->name,
            'avatar'    => @globalAsset(@$this->user->upload->path,'user.png'),
        ];

        return $data;
    }
}
