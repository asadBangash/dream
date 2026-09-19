<?php

namespace Database\Seeders\StudentInfo;

use App\Models\StudentInfo\StudentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentCategory::create([
            'name' => 'Regular'
        ]);
        StudentCategory::create([
            'name' => 'Eregular'
        ]);
    }
}
