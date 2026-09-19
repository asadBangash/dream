<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\MainApp\Entities\Feature;
use Modules\MainApp\Entities\Testimonial;

class TestimonialSeeder extends Seeder
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

        $testimonials = [
            [
                "name" => "John Smith",
                "link" => "www.profile.com/johnsmith",
                "rating" => 4,
                "position" => 1,
                "description" => "The school management system has truly transformed the way we manage our institution. It's user-friendly, efficient, and helps us stay organized with ease."
            ],
            [
                "name" => "Sarah Johnson",
                "link" => "www.profile.com/sarahjohnson",
                "rating" => 5,
                "position" => 2,
                "description" => "As a parent, I'm delighted with the school management system. It keeps me informed about my child's progress, assignments, and activities. It's a game-changer!"
            ],
            [
                "name" => "Michael Brown",
                "link" => "www.profile.com/michaelbrown",
                "rating" => 3,
                "position" => 3,
                "description" => "Teaching becomes much more efficient with the school management system. It streamlines communication, attendance, and assignment tracking, allowing me to focus on teaching."
            ],
            [
                "name" => "Sarah Johnson",
                "link" => "www.profile.com/sarahjohnson",
                "rating" => 2,
                "position" => 4,
                "description" => "As a parent, I'm delighted with the school management system. It keeps me informed about my child's progress, assignments, and activities. It's a game-changer!"
            ],
            [
                "name" => "Emily White",
                "link" => "www.profile.com/emilywhite",
                "rating" => 0,
                "position" => 5,
                "description" => "The school management system has made managing my academic life easier. I can access schedules, assignments, and grades conveniently, even on the go."
            ],
            [
                "name" => "Emma Green",
                "link" => "www.profile.com/emmagreen",
                "rating" => 1,
                "position" => 6,
                "description" => "The school management system has made my student life more organized and manageable. I can keep track of my schedule and assignments effortlessly."
            ]
        ];
        
        
        
        foreach ($testimonials as $key => $value) {
            $row              = new Testimonial();
            $row->name        = $value['name'];
            $row->link        = $value['link'];
            $row->rating      = $value['rating'];
            $row->position    = $value['position'];
            $row->description = $value['description'];
            $row->save();
        }

    }
}
