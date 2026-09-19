<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCard extends BaseModel
{
    use HasFactory;

    public function frontendBg()
    {
        return $this->belongsTo(Upload::class, 'frontside_bg_image', 'id');
    }

    public function backsideBg()
    {
        return $this->belongsTo(Upload::class, 'backside_bg_image', 'id');
    }

    public function qrCode()
    {
        return $this->belongsTo(Upload::class, 'qr_code', 'id');
    }

    public function signatureImage()
    {
        return $this->belongsTo(Upload::class, 'signature', 'id');
    }
}
