<?php

namespace App\Models;

use App\Models\WebsiteSetup\PageSections;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionTranslate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'data',
        'section_id',
        'locale',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function pageSection()
    {
        return $this->belongsTo(PageSections::class, 'section_id', 'id');
    }
}