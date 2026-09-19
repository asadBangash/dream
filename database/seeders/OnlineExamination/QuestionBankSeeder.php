<?php

namespace Database\Seeders\OnlineExamination;

use App\Models\OnlineExamination\QuestionBank;
use App\Models\OnlineExamination\QuestionBankChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [1, "What is your favorite subject?", '4', 2, 4],
            [2, "What are your favorite foods?", ['3','4'], 2, 4],
            [3, "Do you think another name for water is life.", '1', 1, null],
            [4, "What challenges have you faced in your academic journey, and how did you overcome them?", null, 5, null],
        ];

        $options = [
            [1, 'Bangla'],
            [1, 'English'],
            [1, 'Math'],
            [1, 'Art'],
            [2, 'fish '],
            [2, 'chips'],
            [2, 'pizza'],
            [2, 'chicken']
        ];

        foreach ($questions as $key => $item) {
            QuestionBank::create([
                'session_id'        => 1,
                'question_group_id' => '1',
                'type'              => $item[0],
                'question'          => $item[1],
                'answer'            => $item[2],
                'mark'              => $item[3],
                'total_option'      => $item[4]
            ]);
        }

        foreach ($options as $key => $item) {
            QuestionBankChildren::create([
                'question_bank_id' => $item[0],
                'option'           => $item[1],
            ]);
        }

    }
}
