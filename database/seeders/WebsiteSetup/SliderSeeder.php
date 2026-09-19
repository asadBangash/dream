<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\Slider;
use App\Models\SliderTranslate;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Let’s Build Your Future With Onest Shooled 1',
            'Let’s Build Your Future With Onest Shooled 2',
            'Let’s Build Your Future With Onest Shooled 3',
        ];
        $descriptions = [
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 1.',
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 2.',
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 3.',
        ];
        $images = [
            'frontend/img/sliders/03.webp',
            'frontend/img/sliders/02.webp',
            'frontend/img/sliders/01.webp',
        ];
        foreach ($names as $key=>$item) {
            $upload = new Upload();
            $upload->path = $images[$key];
            $upload->save();

            $row = new Slider();
            $row->name = $item;
            $row->description = $descriptions[$key];
            $row->upload_id = $upload->id;
            $row->serial = $key;
            $row->save();
        }

        $en_name = [
            'Let’s Build Your Future With Onest Shooled 1',
            'Let’s Build Your Future With Onest Shooled 2',
            'Let’s Build Your Future With Onest Shooled 3',
        ];
        $en_descriptions = [
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 1.',
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 2.',
            'Wonderful environment where children undertakes laborious physical learn and grow. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sin 3.',
        ];

        $bn_name = [
            'আসুন Oneest Shooled 1 দিয়ে আপনার ভবিষ্যত গড়ে তুলি',
            'আসুন Oneest Shooled 2 দিয়ে আপনার ভবিষ্যত গড়ে তুলি',
            'আসুন Oneest Shooled 3 দিয়ে আপনার ভবিষ্যত গড়ে তুলি',
        ];
        $bn_descriptions = [
            'চমৎকার পরিবেশ যেখানে শিশুরা শ্রমসাধ্য শারীরিক শিক্ষা গ্রহণ করে এবং বড় হয়। আমেট নরম, তারা কোথাও ছেড়ে যায় না, কিছু ব্যথা হতে দিন।',
            'চমৎকার পরিবেশ যেখানে শিশুরা শ্রমসাধ্য শারীরিক শিক্ষা গ্রহণ করে এবং বড় হয়। আমেত একটুও হাল ছাড়ে না, তারা কোথাও ছাড়ে না, কিছু ব্যথা থাকুক।',
            'চমৎকার পরিবেশ যেখানে শিশুরা শ্রমসাধ্য শারীরিক শিক্ষা গ্রহণ করে এবং বড় হয়। তারা আমাকে একা ছেড়ে যায় না।',
        ];

        foreach ($en_name as $key=>$item) {
            $row = new SliderTranslate();
            $row->slider_id = $key+1;
            $row->name = $item;
            $row->locale = 'en';
            $row->description = $en_descriptions[$key];
            $row->save();
        }

        foreach ($bn_name as $key=>$item) {
            $row = new SliderTranslate();
            $row->slider_id = $key+1;
            $row->name = $item;
            $row->locale = 'bn';
            $row->description = $bn_descriptions[$key];
            $row->save();
        }


    }
}
