<?php


namespace App\Http\Resources\Student;


use Illuminate\Http\Resources\Json\JsonResource;

class ChatListResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => $this->first_name . ' ' . $this->last_name,
            "email" => $this->email,
            "status" => $this->status,
            "avatar" => @globalAsset(@$this->upload->path),
            "created_at" => $this->created_at,
            "channel_name" => 'receiver_channel' . $this->user_id,
            "last_message" => new ChatConversionResource($this->lastMessage)
        ];
    }
}
