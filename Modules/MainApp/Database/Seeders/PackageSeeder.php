<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\MainApp\Entities\Package;
use Modules\MainApp\Entities\PackageChild;

class PackageSeeder extends Seeder
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

        $pricings = [
            [
                "name" => "Basic Plan",
                "payment_type" => "prepaid",
                "price" => 99,
                "student_limit" => 3,
                "staff_limit" => 3,
                "duration" => 1,
                "duration_number" => 10,
                "description" => 'For most businesses that want to otpimize web queries',
                "popular" => 0,
                "features" => [1, 2, 3, 6, 10, 13, 14, 15, 16]
            ],
            [
                "name" => "Standard Plan",
                "payment_type" => "prepaid",
                "price" => 199,
                "student_limit" => 4,
                "staff_limit" => 4,
                "duration" => 2,
                "duration_number" => 2,
                "description" => 'For most businesses that want to otpimize web queries',
                "popular" => 0,
                "features" => [1, 2, 3, 4, 5, 6, 7, 10, 13, 14, 15, 16]
            ],
            [
                "name" => "Premium Plan",
                "payment_type" => "prepaid",
                "price" => 299,
                "student_limit" => 5,
                "staff_limit" => 5,
                "duration" => 3,
                "duration_number" => 5,
                "description" => 'For most businesses that want to otpimize web queries',
                "popular" => 1,
                "features" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 13, 14, 15, 16]
            ],
            [
                "name" => "Post Paid",
                "payment_type" => "postpaid",
                "per_student_price" => 5,
                "price" => 0,
                "duration" => 1,
                "duration_number" => 30,
                "description" => 'For most businesses that want to otpimize web queries',
                "popular" => 0,
                "features" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
            ]
        ];
        
        
        foreach ($pricings as $key => $value) {
            $row                 = new Package();
            $row->name           = $value['name'];
            $row->payment_type   = $value['payment_type'];
            $row->per_student_price   = $value['per_student_price'] ?? 0;
            $row->price          = $value['price'];
            $row->student_limit  = $value['student_limit'] ?? null;
            $row->staff_limit    = $value['staff_limit'] ?? null;
            $row->duration       = $value['duration'];
            $row->duration_number= $value['duration_number'];
            $row->description    = $value['description'];
            $row->popular        = $value['popular'];
            $row->save();

            foreach ($value['features'] as $key => $item) {
                $child                 = new PackageChild();
                $child->package_id     = $row->id;
                $child->feature_id     = $item;
                $child->save();
            }
        }

    }
}
