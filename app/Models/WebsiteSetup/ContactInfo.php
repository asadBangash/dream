<?php

namespace App\Models\WebsiteSetup;

use App\Models\ContactInfoTranslate;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;


    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function defaultTranslate()
    {
        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(ContactInfoTranslate::class, 'contact_info_id')->where('locale', $locale);
    }

    public function translations()
    {
        return $this->hasMany(ContactInfoTranslate::class, 'contact_info_id', 'id');
    }
}
