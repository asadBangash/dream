<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class IssuedBookResource extends JsonResource
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
            'book' => $this->book->name,
            'member' => $this->user->name,
            'phone' => $this->phone,
            'issue_date' => dateFormat($this->issue_date),
            'return_date' => dateFormat($this->return_date),
            'status' => $status
        ];
    }
}
