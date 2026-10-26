<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends BaseModel
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(EventTranslate::class, 'event_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(EventTranslate::class, 'event_id', 'id');
    }
}
