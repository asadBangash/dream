<?php

namespace Database\Seeders\Demo;

use App\Models\Certificate;
use App\Models\IdCard;
use Illuminate\Database\Seeder;

class DemoCertificateSeeder extends Seeder
{
    public static int $certificateCount = 0;

    public static int $idCardCount = 0;

    private array $certificates = [
        'Character Certificate',
        'Bonafide Certificate',
        'Achievement Certificate',
        'Leaving Certificate',
    ];

    public function run(): void
    {
        foreach (DemoContext::branches() as $branchId => $branchName) {
            foreach ($this->certificates as $title) {
                $isAchievement = str_contains($title, 'Achievement');
                Certificate::create([
                    'title'                => $isAchievement ? '[class_name]' : ($title . ' — ' . $branchName),
                    'top_text'             => $isAchievement ? '[section_name]' : 'The Dream Tuition Academy',
                    'description'          => $isAchievement ? 'D/o [father_name]' : 'This is to certify that the student has successfully met the requirements for ' . $title . ' at ' . $branchName . '.',
                    'logo_show'            => true,
                    'bottom_left_text'     => $isAchievement ? 'Keep Learning, Keep Growing!' : 'Principal',
                    'bottom_right_text'    => $isAchievement ? 'at The Dream Tuition Academy, [school_location].' : 'Controller of Examinations',
                    'logo'                 => true,
                    'name'                 => true,
                    'branch_id'            => $branchId,
                ]);
                self::$certificateCount++;
            }

            IdCard::create([
                'title'                => 'Student ID — ' . $branchName,
                'card_type'            => \App\Enums\IdCardType::STUDENT,
                'expired_date'         => now()->addYear()->format('Y-m-d'),
                'backside_description' => 'Property of The Dream Tuition Academy, Peshawar.',
                'student_name'         => true,
                'admission_no'         => true,
                'roll_no'              => true,
                'class_name'           => true,
                'section_name'         => true,
                'blood_group'          => true,
                'dob'                  => true,
                'branch_id'            => $branchId,
            ]);
            self::$idCardCount++;
        }
    }
}
