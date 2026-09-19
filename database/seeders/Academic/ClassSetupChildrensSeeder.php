<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\ClassSetupChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSetupChildrensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassSetupChildren::create([
            'class_setup_id'   => 1,
            'section_id'       => 1
        ]);
        ClassSetupChildren::create([
            'class_setup_id'   => 1,
            'section_id'       => 2
        ]);
        ClassSetupChildren::create([
            'class_setup_id'   => 2,
            'section_id'       => 1
        ]);
        ClassSetupChildren::create([
            'class_setup_id'   => 2,
            'section_id'       => 2
        ]);
        ClassSetupChildren::create([
            'class_setup_id'   => 3,
            'section_id'       => 1
        ]);
        ClassSetupChildren::create([
            'class_setup_id'   => 3,
            'section_id'       => 2
        ]);

    }
}
