<?php

namespace App\Models;

use App\Models\SessionTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','start_date','end_date','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function defaultTranslate()
    {
        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(SessionTranslate::class, 'session_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(SessionTranslate::class, 'session_id', 'id');
    }
}
