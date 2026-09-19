<?php

namespace App\Models;

use App\Models\PageTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryCategory extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'gallery_category_id');
    }

    public function translations()
    {
        return $this->hasMany(GalleryCategoryTranslate::class, 'gallery_category_id', 'id');
    }

    public function defaultTranslate()
    {
        $relation = $this->hasOne(GalleryCategoryTranslate::class, 'gallery_category_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(GalleryCategoryTranslate::class, 'gallery_category_id')->where('locale', 'en');
        }
    }
}
