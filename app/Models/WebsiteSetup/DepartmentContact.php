<?php

namespace App\Models\WebsiteSetup;

use App\Models\DepartmentContactTranslate;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentContact extends Model
{
    use HasFactory;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }

    public function defaultTranslate()
    {

        $locale = request()->locale ?? app()->getLocale();

        return $this->hasOne(DepartmentContactTranslate::class, 'department_contact_id')->where('locale', $locale);
    }


    public function translations()
    {
        return $this->hasMany(DepartmentContactTranslate::class, 'department_contact_id', 'id');
    }
}
