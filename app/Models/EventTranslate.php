<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'event_id',
        'locale',
    ];
}