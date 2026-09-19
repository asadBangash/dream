<?php

namespace Modules\MainApp\Entities;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $casts = [
        'data' => 'array'
    ];

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }
}
