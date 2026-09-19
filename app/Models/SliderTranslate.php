<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SliderTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slider_id',
        'locale',
    ];
}