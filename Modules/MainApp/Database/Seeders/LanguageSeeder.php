<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\MainApp\Entities\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'icon_class' => 'flag-icon flag-icon-us',
            'direction'=>'ltr'
        ]);

        Language::create([
            'name' => 'Bangla',
            'code' => 'bn',
            'icon_class' => 'flag-icon flag-icon-bd',
            'direction'=>'ltr'
        ]);
    }
}
