<?php

namespace Database\Seeders\Academic;

use Illuminate\Database\Seeder;
use App\Models\Academic\Classes;
use App\Models\Academic\Subject;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\ClassRoutineChildren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassRoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $classes  = Classes::all();
        // $subjects = Subject::all();
        
        // for ($d=2; $d <= 6; $d++) {  // day = 5

        //     foreach ($classes as $class) {
        //         foreach ($class->classSetup->classSetupChildrenAll as $setup_child) {
        //             $class_routine             = new ClassRoutine();
        //             $class_routine->classes_id = $class->id;

        //             $class_routine->section_id = $setup_child->section_id;
        //             $class_routine->session_id = 1;

        //             $class_routine->day        = $d;
        //             $class_routine->save();

        //             foreach($subjects as $subject) {
        //                 $row                      = new ClassRoutineChildren();
        //                 $row->class_routine_id    = $class_routine->id;
        //                 $row->subject_id          = $subject->id;
        //                 $row->time_schedule_id    = $subject->id;
        //                 $row->class_room_id       = $subject->id;
        //                 $row->save();
        //             }
        //         }
        //     }
        // }

        for ($d=2; $d <= 6; $d++) {  // day = 5
            for ($c=1; $c <= 3; $c++) { // class = 3
                for ($se=1; $se <= 2; $se++) { // section = 2
                    $class_routine             = new ClassRoutine();
                    $class_routine->classes_id = $c;

                    $class_routine->section_id = $se;
                    $class_routine->session_id = 1;

                    $class_routine->day        = $d;
                    $class_routine->save();

                    for ($s= $c+1; $s <= $c+4; $s++) { // subjects = 4
                        $row                      = new ClassRoutineChildren();
                        $row->class_routine_id    = $class_routine->id;
                        $row->subject_id          = $s;
                        $row->time_schedule_id    = $s;
                        $row->class_room_id       = $s;
                        $row->save();
                    }
                }
            }
        }
    }
}
