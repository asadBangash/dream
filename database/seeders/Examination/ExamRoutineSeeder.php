<?php

namespace Database\Seeders\Examination;

use Illuminate\Database\Seeder;
use App\Models\Academic\Classes;
use App\Models\Academic\Subject;
use App\Models\Academic\ExamRoutine;
use App\Models\Academic\ExamRoutineChildren;
use App\Models\Examination\ExamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamRoutineSeeder extends Seeder
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
        // $types    = ExamType::all();
         
        // foreach ($classes as $class) {
        //     foreach ($class->classSetup->classSetupChildrenAll as $setup_child) {
        //         foreach ($types as $type) {
        //             foreach ($subjects as $subject) {
        //                 $exam_routine              = new ExamRoutine();
        //                 $exam_routine->classes_id  = $class->id;
        //                 $exam_routine->section_id  = $setup_child->section_id;
        //                 $exam_routine->session_id  = 1;
        //                 $exam_routine->type_id     = $type->id;
        //                 $exam_routine->date        = date("Y-m-d", strtotime("+ ".$subject->id." day"));
        //                 $exam_routine->save();
                        
        //                 $row                      = new ExamRoutineChildren();
        //                 $row->exam_routine_id     = $exam_routine->id;
        //                 $row->subject_id          = $subject->id;
        //                 $row->time_schedule_id    = $subject->id;
        //                 $row->class_room_id       = $subject->id;
        //                 $row->save();
        //             }
        //         }
        //     }
        // }

        for ($c = 1; $c <= 3; $c++) { // class = 3
            for ($se = 1; $se <= 2; $se++) { // section = 2
                for ($t = 1; $t <= 3; $t++) { // type = 3
                    for ($d = 1; $d <= 4; $d++) { // date = 4
                        $exam_routine              = new ExamRoutine();
                        $exam_routine->classes_id  = $c;
                        $exam_routine->section_id  = $se;
                        $exam_routine->session_id  = 1;
                        $exam_routine->type_id     = $t;
                        $exam_routine->date        = date("Y-m-d", strtotime("+ ".$d." day"));
                        $exam_routine->save();
                        
                        // class + date key wise subject id
                        $row                      = new ExamRoutineChildren();
                        $row->exam_routine_id     = $exam_routine->id;
                        $row->subject_id          = $c + $d;
                        $row->time_schedule_id    = $c + $d;
                        $row->class_room_id       = $c + $d;
                        $row->save();
                    }
                }
            }
        }
    }
}
