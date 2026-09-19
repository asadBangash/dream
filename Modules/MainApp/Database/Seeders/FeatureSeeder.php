<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\MainApp\Entities\Feature;

class FeatureSeeder extends Seeder
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

        $features = [
            [
                "name"        => "Online Admission",
                "key"         => "online_admission",
                "position"    => 1,
                "description" => "The process by which students apply and enroll in educational programs through online platforms."
            ],
            [
                "name"        => "Student Info",
                "key"         => "student_info",
                "position"    => 2,
                "description" => "A repository of information about enrolled students, including personal, contact, and demographic details."
            ],
            [
                "name"        => "Academic",
                "key"         => "academic",
                "position"    => 3,
                "description" => "Encompasses the curriculum, courses, class schedules, and academic progress tracking of students."
            ],
            [
                "name"        => "Routine",
                "key"         => "routine",
                "position"    => 4,
                "description" => "Encompasses the curriculum, courses, class schedules, and Routine progress tracking of students."
            ],
            [
                "name"        => "Attendance",
                "key"         => "attendance",
                "position"    => 5,
                "description" => "Encompasses the curriculum, courses, class schedules, and Attendance progress tracking of students."
            ],
            [
                "name"        => "Fees",
                "key"         => "fees",
                "position"    => 6,
                "description" => "Handles the financial aspects of education, including tuition fees, payment methods, and financial aid."
            ],
            [
                "name"        => "Examination",
                "key"         => "examination",
                "position"    => 7,
                "description" => "Involves scheduling, conducting, and evaluating assessments to measure students' academic performance."
            ],
            [
                "name"        => "Online Examination",
                "key"         => "online_examination",
                "position"    => 8,
                "description" => "Involves scheduling, conducting, and evaluating assessments to measure students' academic performance."
            ],
            [
                "name"        => "Library",
                "key"         => "library",
                "position"    => 9,
                "description" => "Involves scheduling, conducting, and evaluating assessments to measure students' academic performance."
            ],
            [
                "name"        => "Account",
                "key"         => "account",
                "position"    => 10,
                "description" => "Records financial transactions related to tuition, fees, and other financial interactions within the educational institution."
            ],
            [
                "name"        => "Report",
                "key"         => "report",
                "position"    => 11,
                "description" => "Generates various reports related to students' academic performance, attendance, and other relevant metrics."
            ],
            [
                "name"        => "Language",
                "key"         => "language",
                "position"    => 12,
                "description" => "Manages language preferences, translations, and language-related aspects to accommodate diverse student backgrounds."
            ],
            [
                "name"        => "Staff Manage",
                "key"         => "staff_manage",
                "position"    => 13,
                "description" => "Involves assigning, submitting, and evaluating Staff Manage assignments to reinforce learning outside of the classroom."
            ],
            [
                "name"        => "Website Setup",
                "key"         => "website_setup",
                "position"    => 14,
                "description" => "Tracks students' presence and absence in classes, helping to monitor their engagement and participation."
            ],
            [
                "name"        => "Gallery",
                "key"         => "gallery",
                "position"    => 15,
                "description" => "Tracks students' presence and absence in classes, helping to monitor their engagement and participation."
            ],
            [
                "name"        => "Setting",
                "key"         => "setting",
                "position"    => 16,
                "description" => "Tracks students' presence and absence in classes, helping to monitor their engagement and participation."
            ],
        ];


        foreach ($features as $key => $value) {
            $row              = new Feature();
            $row->title       = $value['name'];
            $row->key         = $value['key'];
            $row->description = $value['description'];
            $row->position    = $value['position'];
            $row->save();
        }

    }
}
