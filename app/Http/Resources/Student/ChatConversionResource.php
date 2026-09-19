<?php


namespace App\Http\Resources\Student;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatConversionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'is_seen' => $this->is_seen,
            'type' => $this->sender_id == auth()->id() ? 'outgoing' : 'incoming',
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
