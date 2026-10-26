<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'value' => 'array',
    ];
    
    protected $guarded = ["id"];

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(SettingTranslate::class, 'setting_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(SettingTranslate::class, 'setting_id', 'id');
    }
}
