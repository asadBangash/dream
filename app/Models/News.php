<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends BaseModel
{
    use HasFactory;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(NewsTranslate::class, 'news_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(NewsTranslate::class, 'news_id', 'id');
    }
}
