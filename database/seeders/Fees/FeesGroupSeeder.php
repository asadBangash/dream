<?php

namespace Database\Seeders\Fees;

use App\Models\Fees\FeesGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeesGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeesGroup::create([
            'name'        => 'Monthly fees',
            'description' => 'Fees Group Description.',
        ]);
        FeesGroup::create([
            'name'        => 'Exam fees',
            'description' => 'Fees Group Description 2.',
        ]);
    }
}