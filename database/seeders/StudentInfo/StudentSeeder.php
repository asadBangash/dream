<?php

namespace Database\Seeders\StudentInfo;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentInfo\SessionClassStudent;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c = 1; $c <= 3; $c++) { // class
            for ($s=1; $s <= 2 ; $s++) { // sections
                for ($i = 1; $i <= 14; $i++) { // students

                    $dob = date('Y-m-d', strtotime("-".$c.$s.$i." day"));
                    $user = User::create([
                        'name'              => 'Student'.$c.$s.$i,
                        'phone'             => '0147852'.$c.$s.$i,
                        'email'             => 'student'.$c.$s.$i.'@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => Hash::make('123456'),
                        'role_id'           => 6,
                        'date_of_birth'     => $dob,
                        "uuid"              => Str::uuid(),
                        'permissions'       => []
                    ]);
                    $student = Student::create([
                        'user_id'                 => $user->id,
                        'admission_no'            => '2023'.$c.$s.$i,
                        'roll_no'                 => $i,
                        'first_name'              => 'Student',
                        'last_name'               => ''.$c.$s.$i,
                        'mobile'                  => '0147852'.$c.$s.$i,
                        'email'                   => 'student'.$c.$s.$i.'@gmail.com',
                        'dob'                     => $dob,
                        'admission_date'          => date('Y-m-d', strtotime("+".$c.$s.$i." day")),
                        'religion_id'             => rand(1, 3),
                        'department_id'           => rand(1, 3),
                        'blood_group_id'          => rand(1, 8),
                        'gender_id'               => rand(1, 2),
                        'parent_guardian_id'      => rand(1, 10),
                        'student_category_id'     => rand(1, 2),
                        'status'                  => 1,
                        'previous_school_info'    => 'Cambridge International School, London',
                        'previous_school'         => 1,
                        'emergency_contact'       => '+112345690'.$i+100,
                        'spoken_lang_at_home'     =>  Arr::random(['English', 'Hindi', 'Arabic', 'Spanish']),
                        'nationality'             =>  Arr::random(['Bangladeshi', 'Canadian', 'British', 'American']),
                        'place_of_birth'          =>  Arr::random(['Dhaka Bangladeshi', 'Delhi India', 'New York USA', 'London UK']),
                        'residance_address'          =>  Arr::random(['Dhaka Bangladeshi', 'Delhi India', 'New York USA', 'London UK']),
                        'upload_documents'        => []
                    ]);
                    SessionClassStudent::create([
                        'session_id'                 => setting('session'),
                        'student_id'                 => $student->id,
                        'classes_id'                 => $c,
                        'section_id'                 => $s,
                        'shift_id'                   => rand(1, 3),
                        'roll'                       => $i
                    ]);
                }
            }
        }
    }
}
