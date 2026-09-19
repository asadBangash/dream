<?php

namespace Database\Seeders\Examination;

use Illuminate\Database\Seeder;
use App\Models\Examination\ExaminationSettings;
use App\Models\Examination\MarksGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExaminationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExaminationSettings::create([
            'name'         => 'average_pass_marks',
            'value'        => '33', // percentage
            'session_id'   => setting('session')
        ]);
    }
}
