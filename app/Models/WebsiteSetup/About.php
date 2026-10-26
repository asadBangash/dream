<?php

namespace App\Models\WebsiteSetup;

use App\Models\AboutTranslate;
use App\Models\SliderTranslate;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function icon_upload()
    {
        return $this->belongsTo(Upload::class, 'icon_upload_id', 'id');
    }

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(AboutTranslate::class, 'about_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(AboutTranslate::class, 'about_id', 'id');
    }
}
