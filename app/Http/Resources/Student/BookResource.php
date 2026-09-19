<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        if ($this->status == \App\Enums\Status::ACTIVE){
            $status = ___('common.active');
        }else{
            $status = ___('common.inactive');
        }

        return [
            'id' => $this->id,
            'category' => @$this->category->name,
            'code' => $this->code,
            'author_name' => $this->author_name,
            'rack_no' => $this->rack_no,
            'status' => $status,

        ];
    }
}
