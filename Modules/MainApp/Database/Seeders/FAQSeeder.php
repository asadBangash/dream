<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\MainApp\Entities\Feature;
use Modules\MainApp\Entities\FrequentlyAskedQuestion;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $faqs = [
            [
                "question" => "What is the school management system?",
                "position" => 1,
                "answer" => "The school management system is a software application designed to streamline and automate various administrative and academic processes within an educational institution."
            ],
            [
                "question" => "How can I apply for admission through the system?",
                "position" => 2,
                "answer" => "You can apply for admission by visiting the 'Online Admission' section on our website, filling out the application form, and submitting the required documents as mentioned in the instructions."
            ],
            [
                "question" => "Where can I view my academic progress?",
                "position" => 3,
                "answer" => "You can monitor your academic progress by logging into the system and accessing the 'Academic' section. Here, you can view your courses, class schedules, grades, and other related information."
            ],
            [
                "question" => "How do I pay my tuition fees online?",
                "position" => 4,
                "answer" => "To pay your tuition fees online, navigate to the 'Fees' section, choose the appropriate payment method, and follow the instructions provided. You can make secure online payments using various payment options."
            ],
            [
                "question" => "When will the examinations be held?",
                "position" => 5,
                "answer" => "Examination schedules are usually posted in the 'Examination' section well in advance. You can find details about the exam dates, venues, and any additional instructions there."
            ],
            [
                "question" => "How can I track my attendance record?",
                "position" => 6,
                "answer" => "You can track your attendance by accessing the 'Attendance' section. It will show your attendance history for each class, allowing you to stay updated on your engagement and participation."
            ],
            [
                "question" => "Can I generate reports about my academic performance?",
                "position" => 7,
                "answer" => "Yes, you can generate various academic reports through the 'Report' section. These reports include your grades, attendance summary, and other relevant metrics to assess your academic performance."
            ],
            [
                "question" => "Is there support for multiple languages in the system?",
                "position" => 8,
                "answer" => "Yes, the system supports multiple languages. You can set your preferred language in the 'Language' section, and the system will adapt to your language preference for a better user experience."
            ],
            [
                "question" => "How do I submit homework assignments online?",
                "position" => 9,
                "answer" => "You can submit your homework assignments through the 'Homework' section. Simply upload your assignment files as per the instructions provided by your instructors."
            ],
            [
                "question" => "Where can I seek help if I encounter technical issues?",
                "position" => 10,
                "answer" => "If you face technical issues or need assistance, you can reach out to our technical support team. Contact details and instructions are available in the 'Support' or 'Contact Us' section."
            ]
        ];
        
        
        
        foreach ($faqs as $key => $value) {
            $row              = new FrequentlyAskedQuestion();
            $row->question    = $value['question'];
            $row->answer      = $value['answer'];
            $row->position    = $value['position'];
            $row->save();
        }

    }
}
