<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\ContactInfoTranslate;
use App\Models\Upload;
use App\Models\WebsiteSetup\ContactInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            'frontend/img/contact/contact_1.webp',
            'frontend/img/contact/contact_2.webp',
            'frontend/img/contact/contact_3.webp',
            'frontend/img/contact/contact_4.webp',
        ];

        $uploads = [];
        foreach ($images as $key => $value) {
            $row = new Upload();
            $row->path = $value;
            $row->save();

            $uploads[] = $row->id;
        }

        $academyName = env('APP_NAME', 'The Dream Tuition Academy');
        $address = 'University Road, Peshawar, Khyber Pakhtunkhwa, Pakistan';

        $info = [
            [
                'image' => $uploads[0],
                'name' => $academyName,
                'address' => $address,
            ],
            [
                'image' => $uploads[1],
                'name' => $academyName,
                'address' => $address,
            ],
            [
                'image' => $uploads[2],
                'name' => $academyName,
                'address' => $address,
            ],
            [
                'image' => $uploads[3],
                'name' => $academyName,
                'address' => $address,
            ],
        ];

        $bn_info = [
            [
                'name' => 'دی ڈریم ٹیوشن اکیڈمی',
                'address' => 'یونیورسٹی روڈ، پشاور، خیبر پختونخوا، پاکستان',
            ],
            [
                'name' => 'دی ڈریم ٹیوشن اکیڈمی',
                'address' => 'یونیورسٹی روڈ، پشاور، خیبر پختونخوا، پاکستان',
            ],
            [
                'name' => 'دی ڈریم ٹیوشن اکیڈمی',
                'address' => 'یونیورسٹی روڈ، پشاور، خیبر پختونخوا، پاکستان',
            ],
            [
                'name' => 'دی ڈریم ٹیوشن اکیڈمی',
                'address' => 'یونیورسٹی روڈ، پشاور، خیبر پختونخوا، پاکستان',
            ],
        ];

        foreach ($info as $key => $value) {
            $row = new ContactInfo();
            $row->upload_id = $value['image'];
            $row->name = $value['name'];
            $row->address = $value['address'];
            $row->save();
        }

        foreach ($info as $key => $value) {
            $row = new ContactInfoTranslate();
            $row->contact_info_id = $key+1;
            $row->locale = 'en';
            $row->name = $value['name'];
            $row->address = $value['address'];
            $row->save();
        }

        foreach ($bn_info as $key => $value) {
            $row = new ContactInfoTranslate();
            $row->contact_info_id = $key+1;
            $row->locale = 'bn';
            $row->name = $value['name'];
            $row->address = $value['address'];
            $row->save();
        }
    }
}
