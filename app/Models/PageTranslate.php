<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'page_id',
        'locale',
    ];
}