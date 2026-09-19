<?php

namespace Modules\Forums\Entities;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Forums\Database\factories\ForumPostCommentFactory;

class ForumPostComment extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    protected static function newFactory(): ForumPostCommentFactory
    {
        //return ForumPostCommentFactory::new();
    }

    public function publisher(){
        return $this->belongsTo(User::class,'published_by','id');
    }

    public function approver(){
        return $this->belongsTo(User::class,'approved_by','id');
    }

    public function replies(){
        return $this->hasMany(ForumPostComment::class,'parent_id','id');
    }
}
