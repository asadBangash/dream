<?php

namespace Modules\MainApp\Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Seeder;
use Modules\MainApp\Entities\Feature;
use Modules\MainApp\Entities\Sections;
use Illuminate\Database\Eloquent\Model;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $images = [
            'saas-frontend/img/icon/4.svg',
            'saas-frontend/img/icon/5.svg',
            'saas-frontend/img/icon/6.svg',
            'saas-frontend/img/icon/7.svg',
            'saas-frontend/img/banner/banner.jpg',
        ];

        $uploads = [];
        foreach ($images as $key => $value) {
            $row = new Upload();
            $row->path = $value;
            $row->save();

            $uploads[] = $row->id;
        }

$schoolName = env('APP_NAME', 'School');
$domain     = env('APP_DOMAIN', 'school.com');


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
                'key'         => 'services',
                'name'        => '',
                'description' => '',
                'upload_id'   => null,
                'data'        => [
                    [
                        'title'       => '24x7 Support',
                        'icon'        =>  $uploads[0],
                        'description' => 'Live Chat Online Time: 9.00am To 11.00pm',
                    ],
                    [
                        'title'       => 'Free Consultancy',
                        'icon'        =>  $uploads[1],
                        'description' => 'Queries And Concerns Into And Answered Free Of Charge.',
                    ],
                    [
                        'title'       => 'Customization',
                        'icon'        =>  $uploads[2],
                        'description' => 'All Requirements & Specifications\ Will Be Met.',
                    ],
                    [
                        'title'       => 'Contractual Services',
                        'icon'        =>  $uploads[3],
                        'description' => 'Monthly Recurring Payments Instead Of One Amount',
                    ],
                ],
            ],
            [
                'key'         => 'banner',
                'name'        => $schoolName . ' Education Management System For School & Academy.',
                'description' => 'A School Management System is an essential tool that streamlines administrative tasks, such as student enrollment, attendance tracking, and grade management, providing educators with more time to focus on teaching and student development.',
                'upload_id'   => $uploads[4],
                'data'        => [],
            ],
            [
                'key'         => 'feature',
                'name'        => 'Our Key Feature',
                'description' => 'Our dedicated and relentless support team is always available to assist you. For any queries, concerns or confusion, you can reach us without any hesitation and get your issues resolved',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'package',
                'name'        => 'Pricing Plan',
                'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'testimonial',
                'name'        => 'Trusted By Over 15,000 Customers In 20 Countries',
                'description' => 'These important features help in effective management of clients, both existing and prospective',
                'upload_id'   => null,
                'data'        => [],
            ],
            [
                'key'         => 'contact',
                'name'        => 'Send A Message To Get Your Free Quote',
                'description' => 'Lorem ipsum dolor sit amet consectetur. Est commodo pharetra ac netus enim a eget. Tristique malesuada donec condimentum mi quis porttitor non vitae ultrices.',
                'upload_id'   => null,
                'data'        => [
                    'webocean@gmail.com',
                    '01234567890',
                    'House #148, Road #13/B, Block-E, Banani, Dhaka, Bangladesh'
                ],
            ],
            [
                'key'         => 'faq',
                'name'        => 'Frequently Asked Questions',
                'description' => 'Our dedicated and relentless support team is always available to assist you. For any queries, concerns or confusion, you can reach us without any hesitation and get your issues resolved',
                'upload_id'   => null,
                'data'        => [],
            ],
        ];


        foreach ($data as $key => $value){
            $row              = new Sections();
            $row->key         = $value['key'];
            $row->name        = $value['name'];
            $row->description = $value['description'];
            $row->upload_id   = $value['upload_id'];
            $row->data        = $value['data'];
            $row->save();
        }

    }
}