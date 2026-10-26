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
        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(SliderTranslate::class, 'slider_id')->where('locale', $locale);

    }

    public function translations()
    {
        return $this->hasMany(SliderTranslate::class, 'slider_id', 'id');
    }
}