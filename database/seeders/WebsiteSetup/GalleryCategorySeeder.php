<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\GalleryCategoryTranslate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Admission',
            'Annual Program',
            'Awards',
            'Curriculum'
        ];
        $bn_names = [
            'ভর্তি',
            'বার্ষিক প্রোগ্রাম',
            'পুরস্কার',
            'পাঠ্যক্রম'
        ];

        foreach ($names as $key=>$item) {
            $row = new GalleryCategory();
            $row->name = $item;
            $row->save();
        }

        foreach ($names as $key => $en) {
            $en = new GalleryCategoryTranslate();
            $en->gallery_category_id = $key+1;
            $en->locale = 'en';
            $en->name = $names[$key];

            $en->save();
        }

        foreach ($bn_names as $key => $bn) {
            $bn = new GalleryCategoryTranslate();
            $bn->gallery_category_id = $key+1;
            $bn->locale = 'bn';
            $bn->name = $bn_names[$key];
            $bn->save();
        }
    }
}
