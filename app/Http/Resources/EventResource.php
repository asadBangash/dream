<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'id'                    => $this->id,
            'title'                 => $this->title,
            'slug'                  => Str::slug($this->title) . '-' . $this->id,
            'date'                  => date('d M Y', strtotime($this->date)),
            'start_time'            => Carbon::parse($this->start_time)->format('h:i A'),
            'end_time'              => Carbon::parse($this->end_time)->format('h:i A'),
            'image'                 => @globalAsset(@$this->upload->path, '90X60.webp')
        ];

        if (request('is_view_details')) {
            $data['address']        = $this->address;
            $data['description']    = $this->description;
        }

        return $data;
    }
}
