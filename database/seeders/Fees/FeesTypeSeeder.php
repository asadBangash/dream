<?php

namespace Database\Seeders\Fees;

use App\Models\Fees\FeesType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $exam_types = ['january months fee', 'february month fee', 'march month fee', 'april month fee', 'may month fee', 'first term fee', '2nd term fee', 'last term fee'];

        foreach ($exam_types as $exam_type) {

            FeesType::create([
                'name'        => $exam_type,
                'code'        => $exam_type,
                'description' => "$exam_type Fees Type Description.",
            ]);

        }
    }
}