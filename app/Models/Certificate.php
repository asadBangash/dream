<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends BaseModel
{
    use HasFactory;

    public function bgImage()
    {
        return $this->belongsTo(Upload::class, 'bg_image', 'id');
    }

    public function leftSignature()
    {
        return $this->belongsTo(Upload::class, 'bottom_left_signature', 'id');
    }

    public function rightSignature()
    {
        return $this->belongsTo(Upload::class, 'bottom_right_signature', 'id');
    }
}
