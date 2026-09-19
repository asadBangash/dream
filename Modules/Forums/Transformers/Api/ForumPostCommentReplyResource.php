<?php

namespace Modules\Forums\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumPostCommentReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'publisher_name' => @$this->publisher->name,
            'publisher_avator' => @globalAsset(@$this->publisher->upload->path, '40X40.webp'),
            'approver_name' => @$this->approver->name,
            'approver_avator' => @globalAsset(@$this->approver->upload->path, '40X40.webp'),
            'reply_created' => dateFormat($this->created_at)
        ];
    }
}
