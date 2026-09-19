<?php

namespace Database\Seeders\Academic;

use App\Models\User;
use App\Models\Staff\Staff;
use Illuminate\Database\Seeder;
use App\Models\Academic\Classes;
use App\Models\Academic\Subject;
use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $classes  = Classes::all();
        $subjects = Subject::all();
        $teachers = Staff::whereRoleId(5)->pluck('id')->toArray();

        foreach ($classes as $class) {

            foreach ($class->classSetup->classSetupChildrenAll as $setup_child) {
                
                $subject_assign = SubjectAssign::create([
                    'session_id'   => 1,
                    'classes_id'   => $class->id,
                    'section_id'   => $setup_child->section_id,
                    'status'       => 1,
                ]);

                foreach($subjects as $subject) {

                    SubjectAssignChildren::create([
                        'subject_assign_id'    => $subject_assign->id,
                        'subject_id'           => $subject->id,
                        'staff_id'             => $teachers[rand(0,12)],
                        'status'               => 1,
                    ]);

                }

            }
           
        }

    }
}
