<?php

namespace Modules\Forums\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Forums\Transformers\Api\ForumPostCommentReplyResource;

class ForumPostCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'publisher_name' => @$this->publisher->name,
            'publisher_avator' => @globalAsset(@$this->publisher->upload->path, '40X40.webp'),
            'approver_name' => @$this->approver->name,
            'approver_avator' => @globalAsset(@$this->approver->upload->path, '40X40.webp'),
            'comment_created' => dateFormat($this->created_at),
            'replies' => ForumPostCommentReplyResource::collection($this->replies)
        ];
    }
}
