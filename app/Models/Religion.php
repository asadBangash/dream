<?php

namespace App\Models;

use App\Models\ReligonTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Religion extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }

    public function defaultTranslate()
    {
        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(ReligonTranslate::class, 'religion_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(ReligonTranslate::class, 'religion_id', 'id');
    }
}
