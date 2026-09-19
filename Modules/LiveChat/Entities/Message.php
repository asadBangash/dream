<?php

namespace Modules\LiveChat\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id',
    ];

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'receiver_id');
    }

    public function scopeUser($query)
    {
        return $query->where('sender_id', auth()->user()->id);
    }

    public function scopeUserReceiverIdOrReceiverUserId($query, $id)
    {
        return $query->where('sender_id', auth()->user()->id)->where('receiver_id', $id)->orWhere('sender_id', $id)->where('receiver_id', auth()->user()->id);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_seen', 0);
    }
}
