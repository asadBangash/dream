<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounterTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_count',
        'serial',
        'counter_id',
        'locale',
    ];
}