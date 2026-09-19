<?php

namespace Modules\Forums\Entities;

use App\Models\BaseModel;
use App\Models\Role;
use App\Models\User;
use App\Models\Upload;
use PhpParser\Node\Expr\Cast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Forums\Database\factories\ForumPostFactory;

class ForumPost extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'target_roles' => 'array', // Ensure target_roles is treated as an array
    ];

    protected $fillable = [
        'title',
        'slug',
        'views_count',
        'target_roles',
        'description',
        'upload_id',
        'status',
        'is_published',
        'approved_by',
        'approval_status',
        'approved_at',
        'published_by',
        'published_at',
        'created_by',
    ];

    protected static function newFactory(): ForumPostFactory
    {
        //return ForumPostFactory::new();
    }


    public function publisher(){
        return $this->belongsTo(User::class,'published_by','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function approver(){
        return $this->belongsTo(User::class,'approved_by','id');
    }

    public function rejector(){
        return $this->belongsTo(User::class,'rejected_by','id');
    }

    public function comments(){
        return $this->hasMany(ForumPostComment::class,'forum_post_id','id')->whereNull('parent_id');
    }

    public function upload(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function getTargetRolesAttribute($value)
    {
        // Ensure the value is returned as an array, even if it's null or improperly formatted
        return $value ? json_decode($value, true) : [];
    }

    public function roles()
    {
        return Role::whereIn('id', $this->target_roles ?: [])->pluck('name','id');
    }

    public function commentsAndReply()
    {
        return $this->hasMany(ForumPostComment::class, 'forum_post_id', 'id');
    }

    public function pending()
    {
        return $this->belongsTo(User::class, 'pending_by', 'id');
    }


}
