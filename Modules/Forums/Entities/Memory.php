<?php

namespace Modules\Forums\Entities;

use App\Models\BaseModel;
use App\Models\Upload;
use App\Models\User;
use Modules\Forums\Database\factories\MemoryFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memory extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'feature_image_id',
        'is_published',
        'approved_by',
        'approval_status',
        'approved_at',
        'published_by',
        'published_at',
        'created_by',
    ];

    protected static function newFactory(): MemoryFactory
    {
        //return MemoryFactory::new();
    }


    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }


    public function feature_image(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'feature_image_id', 'id');
    }


    public function galleries()
    {
        return $this->hasMany(MemoryGallery::class, 'memory_id', 'id');
    }

    public function rejector(){
        return $this->belongsTo(User::class,'rejected_by','id');
    }

    public function pending()
    {
        return $this->belongsTo(User::class, 'pending_by', 'id');
    }
}
