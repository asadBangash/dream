<?php

namespace Database\Seeders\Examination;

use App\Models\Examination\ExamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamType::create([
            'name' => 'First Term Exam'
        ]);
        ExamType::create([
            'name' => 'Mid Term Exam'
        ]);
        ExamType::create([
            'name' => 'Final Exam'
        ]);
    }
}
