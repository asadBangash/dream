<?php

namespace Modules\LiveChat\Entities;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageUser extends User
{
    use HasFactory;

    protected $table = 'users';


    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'sender_id')->latest();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('is_seen', 0);
    }

    public function receiverMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function scopeUserMessages($query, $id)
    {
        return $query->whereHas('messages', function ($query) use ($id) {
            $query->where('sender_id', auth()->user()->id)->where('receiver_id', $id)->orWhere('sender_id', $id)->where('receiver_id', auth()->user()->id);
        });
    }

    public function scopeSearch($query, $req)
    {
        $where = [];
        if (@$req->key) {
            $where[] = ['name', 'like', '%' . @$req->key . '%'];
        }
        return $query->where($where);
    }

}
