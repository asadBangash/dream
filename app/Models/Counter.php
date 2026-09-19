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

        $relation = $this->hasOne(CounterTranslate::class, 'counter_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(CounterTranslate::class, 'counter_id')->where('locale', 'en');
        }
    }


    public function translations()
    {
        return $this->hasMany(CounterTranslate::class, 'counter_id', 'id');
    }
}
