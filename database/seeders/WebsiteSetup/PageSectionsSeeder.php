<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\SectionTranslate;
use App\Models\Upload;
use App\Models\WebsiteSetup\PageSections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $images = [
            'frontend/img/accreditation/accreditation.webp',
            'frontend/img/banner/cta_bg.webp',
            'frontend/img/explore/1.webp',
            'frontend/img/icon/1.svg',
            'frontend/img/icon/2.svg',
            'frontend/img/icon/3.svg',
        ];

        $uploads = [];
        foreach ($images as $key => $value) {
            $row = new Upload();
            $row->path = $value;
            $row->save();

            $uploads[] = $row->id;
        }


        $data = [
            [
                'key'         => 'social_links',
                'name'        => '',
                'description' => '',
                'upload_id'   => null,
                'data'        => [
                    [
                        'name' => 'Facebook',
                        'icon' => 'fab fa-facebook-f',
                        'link' => 'http://www.facebook.com'
                    ],
                    [
                        'name' => 'Twitter',
                        'icon' => 'fab fa-twitter',
                        'link' => 'http://www.twitter.com'
                    ],
                    [
                        'name' => 'Pinterest',
                        'icon' => 'fab fa-pinterest-p',
                        'link' => 'http://www.pinterest.com',
                    ],
                    [
                        'name' => 'Instagram',
                        'icon' => 'fab fa-instagram',
                        'link' => 'http://www.instagram.com',
                    ]
                ],
            ],
            [
                'key'         => 'statement',
                'name'        => 'Statement Of Onest Schooleded',
                'description' => '',
                'upload_id'   => $uploads[0],
                'data'        => [
                    [
                        'title'       => 'Mission Statement',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Read More',
                    ],
                    [
                        'title'       => 'Vision Statement',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet Read More',
                    ],
                ],
            ],
            [
                'key'         => 'study_at',
                'name'        => 'Study at Onest Schooleded',
                'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. veniam consequat sunt nostrud amet',
                'upload_id'   => $uploads[1],
                'data'        => [
                    [
                        'icon'        => $uploads[3],
                        'title'       => 'Out Prospects',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. veniam consequat sunt nostrud amet',
                    ],
                    [
                        'icon'        => $uploads[4],
                        'title'       => 'Out Prospects',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. veniam consequat sunt nostrud amet',
                    ],
                    [
                        'icon'        => $uploads[5],
                        'title'       => 'Out Prospects',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. veniam consequat sunt nostrud amet',
                    ],
                ],
            ],
            [
                'key'         => 'explore',
                'name'        => 'Explore Onest Schoooled',
                'description' => '"We Educate Knowledge & Essential Skills" is a phrase that emphasizes the importance of both theoretical knowledge',
                'upload_id'   => $uploads[2],
                'data'        => [
                    [
                        'tab' => 'Campus Life',
                        'title' => 'Campus Life',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud'
                    ],
                    [
                        'tab' => 'Academic',
                        'title' => 'Academic',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud'
                    ],
                    [
                        'tab' => 'Athletics',
                        'title' => 'Athletics',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud'
                    ],
                    [
                        'tab' => 'School',
                        'title' => 'School',
                        'description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud'
                    ],
                ],
            ],
            [
                'key'         => 'why_choose_us',
                'name'        => 'Excellence In Teaching And Learning',
                'description' => 'Welcomed every pain avoided but in certain circumstances owing obligations of business it will to the claims of duty or the obligations of business it will frequently occurs that pleasures. Provide Endless Opportunities',
                'upload_id'   => null,
                'data'        => [
                    'A higher education qualification',
                    'Better career prospects',
                    'Better career prospects',
                    'Better career prospects'
                ],
            ],
            [
                'key'         => 'academic_curriculum',
                'name'        => '20+ Academic Curriculum',
                'description' => 'Onsest Schooled is home to more than 20,000 students and 230,000 alumni with a wide variety of interests, ages and backgrounds, the University reflects the city’s dynamic mix of populations.',
                'upload_id'   => null,
                'data'        => [
                    'Bangal Medium',
                    'Bangal Medium',
                    'Bangal Medium',
                    'Bangal Medium',
                    'Bangal Medium',
                    'Bangal Medium',
                ],
            ],
            [
                'key'         => 'coming_up',
                'name'        => 'What’s Coming Up?',
                'description' => 'Welcomed every pain avoided but in certain circumstances owing obligations of business it will to the claims of duty or the obligation.',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'news',
                'name'        => 'Latest From Our Blog',
                'description' => 'Welcomed every pain avoided but in certain circumstances owing obligations of business it will to the claims of duty or the obligation.',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'our_gallery',
                'name'        => 'Our Gallery',
                'description' => 'Welcomed every pain avoided but in certain circumstances owing obligations of business it will to the claims of duty or the obligation.',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'contact_information',
                'name'        => 'Find Our <br> Contact Information',
                'description' => '',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'department_contact_information',
                'name'        => 'Contact By Department',
                'description' => 'Welcomed every pain avoided but in certain circumstances owing obligations of business it will to the claims of duty or the obligations of business it will',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'our_teachers',
                'name'        => 'Our Featured Teachers',
                'description' => '',
                'upload_id'   => null,
                'data'        => [],
            ],
        ];

        $bn_data = [
            [
                'key'         => 'social_links',
                'name'        => '',
                'description' => '',
                'upload_id'   => null,
                'data'        => [
                    [
                        'name' => 'ফেসবুক',
                        'icon' => 'fab fa-facebook-f',
                        'link' => 'http://www.facebook.com'
                    ],
                    [
                        'name' => 'টুইটার',
                        'icon' => 'fab fa-twitter',
                        'link' => 'http://www.twitter.com'
                    ],
                    [
                        'name' => 'Pinterest',
                        'icon' => 'fab fa-pinterest-p',
                        'link' => 'http://www.pinterest.com',
                    ],
                    [
                        'name' => 'ইনস্টাগ্রাম',
                        'icon' => 'fab fa-instagram',
                        'link' => 'http://www.instagram.com',
                    ]
                ],
            ],
            [
                'key'         => 'statement',
                'name'        => 'Onest Schooled এর স্টেটমেন্ট',
                'description' => '',
                'upload_id'   => $uploads[0],
                'data'        => [
                    [
                        'title'       => 'মিশন বিবৃতি',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। আরও পড়ুন',
                    ],
                    [
                        'title'       => 'দৃষ্টি বিবৃতি',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। ব্যায়াম আপনাকে আরও পড়তে শিখতে সাহায্য করবে',
                    ],
                ],
            ],
            [
                'key'         => 'study_at',
                'name'        => 'শিক্ষাদান এবং শেখার ক্ষেত্রে শ্রেষ্ঠত্ব',
                'description' => 'Onsest Schooled হল 20,000 টিরও বেশি ছাত্র এবং 230,000 প্রাক্তন ছাত্রদের বিভিন্ন ধরনের আগ্রহ, বয়স এবং ব্যাকগ্রাউন্ড সহ, বিশ্ববিদ্যালয়টি শহরের জনসংখ্যার গতিশীল মিশ্রণকে প্রতিফলিত করে।',
                'upload_id'   => $uploads[1],
                'data'        => [
                    [
                        'icon'        => $uploads[3],
                        'title'       => 'Out Prospects',
                        'description' => 'Onsest Schooled হল 20,000 টিরও বেশি ছাত্র এবং 230,000 প্রাক্তন ছাত্রদের বিভিন্ন ধরনের আগ্রহ, বয়স এবং ব্যাকগ্রাউন্ড সহ, বিশ্ববিদ্যালয়টি শহরের জনসংখ্যার গতিশীল মিশ্রণকে প্রতিফলিত করে।',
                    ],
                    [
                        'icon'        => $uploads[4],
                        'title'       => 'Out Prospects',
                        'description' => 'Onsest Schooled হল 20,000 টিরও বেশি ছাত্র এবং 230,000 প্রাক্তন ছাত্রদের বিভিন্ন ধরনের আগ্রহ, বয়স এবং ব্যাকগ্রাউন্ড সহ, বিশ্ববিদ্যালয়টি শহরের জনসংখ্যার গতিশীল মিশ্রণকে প্রতিফলিত করে।',
                    ],
                    [
                        'icon'        => $uploads[5],
                        'title'       => 'Out Prospects',
                        'description' => 'Onsest Schooled হল 20,000 টিরও বেশি ছাত্র এবং 230,000 প্রাক্তন ছাত্রদের বিভিন্ন ধরনের আগ্রহ, বয়স এবং ব্যাকগ্রাউন্ড সহ, বিশ্ববিদ্যালয়টি শহরের জনসংখ্যার গতিশীল মিশ্রণকে প্রতিফলিত করে।',
                    ],
                ],
            ],
            [
                'key'         => 'explore',
                'name'        => 'অনেস্ট স্কুলড এক্সপ্লোর করুন',
                'description' => '"আমরা জ্ঞান এবং অপরিহার্য দক্ষতা শিক্ষা করি" একটি বাক্যাংশ যা উভয় তাত্ত্বিক জ্ঞানের গুরুত্বের উপর জোর দেয়',
                'upload_id'   => $uploads[2],
                'data'        => [
                    [
                        'tab' => 'ক্যাম্পাস জীবন',
                        'title' => 'ক্যাম্পাস জীবন',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে'
                    ],
                    [
                        'tab' => 'একাডেমিক',
                        'title' => 'একাডেমিক',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে'
                    ],
                    [
                        'tab' => 'অ্যাথলেটিক্স',
                        'title' => 'অ্যাথলেটিক্স',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে'
                    ],
                    [
                        'tab' => 'বিদ্যালয়',
                        'title' => 'বিদ্যালয়',
                        'description' => 'তারা খুব নরম এবং কোথাও কোন ব্যথা আছে ছেড়ে না. তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে। তিনি তার পরিবারের যত্ন নিতে পছন্দ করেন। অনুশীলন ফলপ্রসূ হবে'
                    ],
                ],
            ],
            [
                'key'         => 'why_choose_us',
                'name'        => 'শিক্ষাদান এবং শেখার ক্ষেত্রে শ্রেষ্ঠত্ব',
                'description' => 'স্বাগত জানাই প্রতিটি ব্যথা এড়িয়ে যাওয়া কিন্তু নির্দিষ্ট পরিস্থিতিতে ব্যবসার বাধ্যবাধকতার কারণে এটি দায়িত্বের দাবি বা ব্যবসার বাধ্যবাধকতাগুলির জন্য এটি প্রায়শই ঘটবে যে আনন্দ। অফুরন্ত সুযোগ প্রদান',
                'upload_id'   => null,
                'data'        => [
                    'উচ্চ শিক্ষাগত যোগ্যতা',
                    'ক্যারিয়ারের আরও ভালো সম্ভাবনা',
                    'ক্যারিয়ারের আরও ভালো সম্ভাবনা',
                    'ক্যারিয়ারের আরও ভালো সম্ভাবনা'
                ],
            ],
            [
                'key'         => 'academic_curriculum',
                'name'        => '20+ একাডেমিক পাঠ্যক্রম',
                'description' => 'Onsest Schooled হল 20,000 টিরও বেশি ছাত্র এবং 230,000 প্রাক্তন ছাত্রদের বিভিন্ন ধরনের আগ্রহ, বয়স এবং ব্যাকগ্রাউন্ড সহ, বিশ্ববিদ্যালয়টি শহরের জনসংখ্যার গতিশীল মিশ্রণকে প্রতিফলিত করে।',
                'upload_id'   => null,
                'data'        => [
                    'বাংলা মাধ্যম',
                    'বাংলা মাধ্যম',
                    'বাংলা মাধ্যম',
                    'বাংলা মাধ্যম',
                    'বাংলা মাধ্যম',
                    'বাংলা মাধ্যম',
                ],
            ],
            [
                'key'         => 'coming_up',
                'name'        => 'কি আসছে?',
                'description' => 'স্বাগত জানাই প্রতিটি ব্যথা এড়িয়ে যাওয়া তবে নির্দিষ্ট পরিস্থিতিতে ব্যবসার বাধ্যবাধকতার কারণে এটি কর্তব্য বা বাধ্যবাধকতার দাবিতে হবে।',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'news',
                'name'        => 'আমাদের ব্লগ থেকে সর্বশেষ',
                'description' => 'স্বাগত জানাই প্রতিটি ব্যথা এড়িয়ে যাওয়া তবে নির্দিষ্ট পরিস্থিতিতে ব্যবসার বাধ্যবাধকতার কারণে এটি কর্তব্য বা বাধ্যবাধকতার দাবিতে হবে।',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'our_gallery',
                'name'        => 'আমাদের গ্যালারি',
                'description' => 'স্বাগত জানাই প্রতিটি ব্যথা এড়িয়ে যাওয়া তবে নির্দিষ্ট পরিস্থিতিতে ব্যবসার বাধ্যবাধকতার কারণে এটি কর্তব্য বা বাধ্যবাধকতার দাবিতে হবে।',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'contact_information',
                'name'        => 'আমাদের যোগাযোগের তথ্য খুঁজুন',
                'description' => '',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'department_contact_information',
                'name'        => 'বিভাগ দ্বারা যোগাযোগ',
                'description' => 'স্বাগত জানাই প্রতিটি কষ্টকে এড়িয়ে যাওয়া কিন্তু কিছু নির্দিষ্ট পরিস্থিতিতে ব্যবসার বাধ্যবাধকতার কারণে এটি দায়িত্বের দাবি বা ব্যবসার বাধ্যবাধকতার জন্য এটি করবে',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'our_teachers',
                'name'        => 'আমাদের বৈশিষ্ট্যযুক্ত শিক্ষক',
                'description' => '',
                'upload_id'   => null,
                'data'        => [],
            ],
        ];


        foreach ($data as $key => $value){
            $row              = new PageSections();
            $row->key         = $value['key'];
            $row->name        = $value['name'];
            $row->description = $value['description'];
            $row->upload_id   = $value['upload_id'];
            $row->data        = $value['data'];
            $row->save();
        }

        foreach ($data as $key => $en_item) {
            $en = new SectionTranslate();
            $en->section_id = $key+1;
            $en->locale = 'en';
            $en->name = $en_item['name'];
            $en->description = $en_item['description'];
            $en->data        = json_encode($en_item['data']);
            $en->save();
        }

        foreach ($bn_data as $key => $bn_item) {
            $bn = new SectionTranslate();
            $bn->section_id = $key+1;
            $bn->locale = 'bn';
            $bn->name = $bn_item['name'];
            $bn->description = $bn_item['description'];
            $bn->data        = json_encode($bn_item['data']);
            $bn->save();
        }

    }
}
