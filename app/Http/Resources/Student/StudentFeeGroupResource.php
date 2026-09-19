<?php

namespace App\Http\Resources\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentFeeGroupResource extends JsonResource
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
            'id'    => $this->id,
            'name'  => $this->name,
            'slug'  => Str::slug($this->name) . '-' . @sessionClassStudent()->section_id
        ];
    }
}
