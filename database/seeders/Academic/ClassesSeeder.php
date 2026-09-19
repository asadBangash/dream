<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classes::create([
            'name' => 'One'
        ]);
        Classes::create([
            'name' => 'Two'
        ]);
        Classes::create([
            'name' => 'Three'
        ]);
    }
}
