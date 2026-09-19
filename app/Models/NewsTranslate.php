<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'news_id',
        'locale',
    ];
}