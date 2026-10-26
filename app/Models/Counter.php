<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends BaseModel
{
    use HasFactory;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(CounterTranslate::class, 'counter_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(CounterTranslate::class, 'counter_id', 'id');
    }
}
