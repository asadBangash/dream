<?php

namespace App\Http\Resources\Teacher\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveClassListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
    //    return parent::toArray($request);
       return [
        'id' => $this->id,
        'title' => $this->title,
        'class' => @$this->class->name,
        'section' => @$this->section->name,
        'subject' => @$this->subject->name,
        'start' => dateFormat($this->start),
        'end' => dateFormat($this->end),
        'status' => $this->status,
        'gmeet_link' => $this->gmeet_link,
       ];
    }
}
