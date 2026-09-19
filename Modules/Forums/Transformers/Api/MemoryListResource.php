<?php

namespace Modules\Forums\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MemoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'feature_image' => @globalAsset(@$this->feature_image->path, '40X40.webp'),
            'publisher_name' => @$this->publisher->name,
            'publisher_avator' => @globalAsset(@$this->publisher->upload->path, '40X40.webp'),
            'published_at' => humanReadableDate($this->published_at),
            'galleries_images_count' => $this->galleries_count,
        ];
    }
}
