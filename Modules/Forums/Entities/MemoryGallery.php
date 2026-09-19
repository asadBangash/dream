<?php

namespace Modules\Forums\Entities;

use App\Models\BaseModel;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Forums\Database\factories\MemoryGalleryFactory;

class MemoryGallery extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): MemoryGalleryFactory
    {
        //return MemoryGalleryFactory::new();
    }


    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'gallery_image_id', 'id');
    }
}
