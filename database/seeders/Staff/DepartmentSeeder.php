<?php

namespace Database\Seeders\Staff;

use App\Models\Staff\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'History'
        ]);
        Department::create([
            'name' => 'Science'
        ]);
        Department::create([
            'name' => 'Business'
        ]);
    }
}
