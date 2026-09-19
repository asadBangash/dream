<?php

namespace App\Http\Resources\Teacher\Api;

use App\Enums\SubjectType;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => ($this->type == 1) ? 'Theory' : 'Practical',
        ];
    }
}
