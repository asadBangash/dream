<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id']         = $this->id;
        $data['name']       = $this->first_name . ' ' . $this->last_name;
        $data['email']      = $this->email;
        $data['phone']      = $this->phone;
        $data['avatar']     = @globalAsset(@$this->upload->path, '40X40.webp');

        if (request()->filled('is_details')) {
            $data['emergency_contact']  = $this->emergency_contact;
            $data['address']            = $this->current_address;
        }

        return $data;
    }
}
