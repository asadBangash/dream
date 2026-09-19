<?php

namespace Database\Seeders\OnlineExamination;

use App\Models\OnlineExamination\QuestionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            "Class test",
            "Quiz test",
            "General test",
            "Online test",
            "MCQ test"
        ];

        foreach ($questions as $key => $item) {
            QuestionGroup::create([
                'session_id' => 1,
                'name'       => $item
            ]);
        }
    }
}
