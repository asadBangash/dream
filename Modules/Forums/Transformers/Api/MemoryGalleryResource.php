<?php

namespace Modules\Forums\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MemoryGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'image' =>  @globalAsset(@$this->image->path, '40X40.webp'),
            'published_at' => humanReadableDate($this->published_at),
        ];
    }
}
