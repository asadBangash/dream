<?php

namespace Modules\Forums\Transformers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumPostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'image' => @globalAsset(@$this->upload->path, '40X40.webp'),
            'short_desc' => Str::limit($this->description, 30, '...'),
            'publisher_name' => @$this->publisher->name,
            'publisher_avator' => @globalAsset(@$this->publisher->upload->path, '40X40.webp'),
            'approver_name' => @$this->approver->name,
            'approver_avator' => @globalAsset(@$this->approver->upload->path, '40X40.webp'),
            'active_status' => $this->status ? 'Active' : 'InActive',
            'publish_status' => $this->is_published ? 'Published' : 'UnPublished',
            'published_at' => humanReadableDate($this->published_at),
            'total_views' => $this->views_count,
            'comments_count' => count($this->comments ?? []),
        ];
    }
}
