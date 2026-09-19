<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'features_name' => 'array',
        'features' => 'array',
    ];

    public function scopeActive($query)
    {
        $query->where('status', Status::ACTIVE);
    }
}
