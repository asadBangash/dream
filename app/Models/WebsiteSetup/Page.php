<?php

namespace App\Models\WebsiteSetup;

use App\Models\PageTranslate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;


    public function defaultTranslate()
    {
        $relation = $this->hasOne(PageTranslate::class, 'page_id')->where('locale', request()->locale ?? config('app.locale'));
        if ($relation->exists()) {
            return $relation;
        } else {
            return $this->hasOne(PageTranslate::class, 'page_id')->where('locale', 'en');
        }
    }


    public function translations()
    {
        return $this->hasMany(PageTranslate::class, 'page_id', 'id');
    }


}
