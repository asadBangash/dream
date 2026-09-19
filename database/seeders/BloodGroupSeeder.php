<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BloodGroup::create([
            'name' => 'A+'
        ]);
        BloodGroup::create([
            'name' => 'A-'
        ]);
        BloodGroup::create([
            'name' => 'B+'
        ]);
        BloodGroup::create([
            'name' => 'B-'
        ]);
        BloodGroup::create([
            'name' => 'O+'
        ]);
        BloodGroup::create([
            'name' => 'O-'
        ]);
        BloodGroup::create([
            'name' => 'AB+'
        ]);
        BloodGroup::create([
            'name' => 'AB-'
        ]);
    }
}
