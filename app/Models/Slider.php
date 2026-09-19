<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends BaseModel
{
    use HasFactory;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function defaultTranslate()
    {
        $relation = $this->hasOne(SliderTranslate::class, 'slider_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(SliderTranslate::class, 'slider_id')->where('locale', 'en');
        }

    }

    public function translations()
    {
        return $this->hasMany(SliderTranslate::class, 'slider_id', 'id');
    }
}