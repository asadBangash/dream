<?php

namespace Database\Seeders\OnlineExamination;

use App\Models\OnlineExamination\OnlineExam;
use App\Models\OnlineExamination\OnlineExamChildrenQuestions;
use App\Models\OnlineExamination\OnlineExamChildrenStudents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnlineExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams = [
            ["First term exam",null,10, date('Y-m-d H:i:s', strtotime("+0 day")), date('Y-m-d H:i:s', strtotime("+2 day")), date('Y-m-d H:i:s', strtotime("-2 day"))],
            ["Second term exam",1,10, date('Y-m-d H:i:s', strtotime("+0 day")), date('Y-m-d H:i:s', strtotime("+2 day")), date('Y-m-d H:i:s', strtotime("-1 day"))],
            ["Third term exam",1,10, date('Y-m-d H:i:s', strtotime("+1 day")), date('Y-m-d H:i:s', strtotime("+3 day")), date('Y-m-d H:i:s', strtotime("+1 day"))],
        ];

        $questions = [
            1, 2, 3, 4
        ];

        $students = [
            1, 2, 3, 4, 5
        ];

        foreach ($exams as $key => $item) {
            $row = OnlineExam::create([
                'session_id'        => 1, // 2023
                'classes_id'        => 1, // One
                'section_id'        => 1, // A
                'subject_id'        => null,
                'name'              => $item[0],
                'exam_type_id'      => $item[1],
                'total_mark'        => $item[2],
                'start'             => $item[3],
                'end'               => $item[4],
                'published'         => $item[5],
                'question_group_id' => 1
            ]);

            foreach ($questions as $key => $value) {
                OnlineExamChildrenQuestions::create([
                    'online_exam_id'   => $row->id,
                    'question_bank_id' => $value
                ]);
            }

            foreach ($students as $key => $value) {
                OnlineExamChildrenStudents::create([
                    'online_exam_id' => $row->id,
                    'student_id'     => $value
                ]);
            }
        }
    }
}
