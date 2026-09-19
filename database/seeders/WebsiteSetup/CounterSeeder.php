<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\Counter;
use App\Models\CounterTranslate;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Curriculum',
            'Students',
            'Expert Teachers',
            'User',
            'Parents',
        ];
        $images = [
            'frontend/img/counters/01.webp',
            'frontend/img/counters/02.webp',
            'frontend/img/counters/03.webp',
            'frontend/img/counters/04.webp',
            'frontend/img/counters/05.webp',
        ];

        $bn_names = [
            'পাঠ্যক্রম',
            'ছাত্ররা',
            'বিশেষজ্ঞ শিক্ষক',
            'ব্যবহারকারী',
            'পিতামাতা',
        ];

        $bn_count = [
            '০',
            '৪৫',
            '৯০',
            '১৩৫',
            '১৮০',
        ];
        $bn_key = [
            '০',
            '১',
            '২',
            '৩',
            '৪',
        ];

        foreach ($names as $key=>$item) {
            $upload = new Upload();
            $upload->path = $images[$key];
            $upload->save();

            $row = new Counter();
            $row->name = $item;
            $row->total_count = 45*$key;
            $row->upload_id = $upload->id;
            $row->serial = $key;
            $row->save();
        }

        foreach ($names as $key => $en_page) {
            $en = new CounterTranslate();
            $en->counter_id = $key+1;
            $en->locale = 'en';
            $en->name = $en_page;
            $en->total_count = 45*$key;
            $en->serial = $key;
            $en->save();
        }

        foreach ($bn_names as $key => $bn_page) {
            $bn = new CounterTranslate();
            $bn->counter_id = $key+1;
            $bn->locale = 'bn';
            $bn->name = $bn_page;
            $bn->total_count = $bn_count[$key];
            $bn->serial = $bn_key[$key];
            $bn->save();
        }
    }
}
