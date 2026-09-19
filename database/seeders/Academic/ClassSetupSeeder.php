<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\ClassSetup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassSetup::create([
            'session_id' => 1,
            'classes_id' => 1
        ]);
        ClassSetup::create([
            'session_id' => 1,
            'classes_id' => 2
        ]);
        ClassSetup::create([
            'session_id' => 1,
            'classes_id' => 3
        ]);
    }
}
