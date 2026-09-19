<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\AboutTranslate;
use App\Models\Upload;
use App\Models\WebsiteSetup\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Special Campus Tour',
            'Graduation',
            'Powerful Alumni',
        ];
        $descriptions = [
            'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
            'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
            'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Exercitation veniam consequat sunt nostrud amet. enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
        ];
        $bn_names = [
            'বিশেষ ক্যাম্পাস সফর',
            'স্নাতক',
            'শক্তিশালী প্রাক্তন ছাত্র',
        ];
        $bn_descriptions = [
            'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে।',
            'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে।',
            'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে। অনুশীলন ফলপ্রসূ হবে। কারণ সে নরম হতে চায়। অনুশীলন ফলপ্রসূ হবে।', ];

        $icons = [
            'frontend/img/about-gallery/icon_1.webp',
            'frontend/img/about-gallery/icon_2.webp',
            'frontend/img/about-gallery/icon_3.webp',
        ];
        $images = [
            'frontend/img/about-gallery/1.webp',
            'frontend/img/about-gallery/2.webp',
            'frontend/img/about-gallery/3.webp',
        ];
        foreach ($names as $key=>$item) {
            $upload       = new Upload();
            $upload->path = $images[$key];
            $upload->save();

            $icon       = new Upload();
            $icon->path = $icons[$key];
            $icon->save();

            $row                 = new About();
            $row->name           = $item;
            $row->description    = $descriptions[$key];
            $row->upload_id      = $upload->id;
            $row->icon_upload_id = $icon->id;
            $row->serial         = $key;
            $row->save();
        }


        foreach ($names as $key => $en_page) {
            $en = new AboutTranslate();
            $en->about_id = $key+1;
            $en->locale = 'en';
            $en->name = $en_page;
            $en->description = $descriptions[$key];
            $en->save();
        }

        foreach ($bn_names as $key => $bn_page) {
            $bn = new AboutTranslate();
            $bn->about_id = $key+1;
            $bn->locale = 'bn';
            $bn->name = $bn_page;
            $bn->description = $bn_descriptions[$key];
            $bn->save();
        }

    }
}
