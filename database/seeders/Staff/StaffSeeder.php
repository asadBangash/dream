<?php

namespace Database\Seeders\Staff;

use App\Models\User;
use App\Models\Upload;
use App\Models\Staff\Staff;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=1; $i < 14; $i++) {

            $upload = new Upload();
            $upload->path = 'frontend/img/instractors/'.$i.'.webp';
            $upload->save();

            $user                     = new User();
            $user->name               = 'Teacher '.$i;
            $user->email              = 'teacher'.$i.'@gmail.com';
            $user->phone              = '014789625'.$i;
            $user->password           = Hash::make('123456');
            $user->email_verified_at  = now();
            $user->role_id            = 5;
            $user->uuid               = Str::uuid();
            $user->permissions        = [
                // gallery_category
                'gallery_category_read',
                'gallery_category_create',
                'gallery_category_update',
                'gallery_category_delete',
                // gallery
                'gallery_read',
                'gallery_create',
                'gallery_update',
                'gallery_delete',
                // marks_register
                'marks_register_read',
                'marks_register_create',
                'marks_register_update',
                'marks_register_delete',
                // exam_routine
                'exam_routine_read',
                'exam_routine_create',
                'exam_routine_update',
                'exam_routine_delete',
                // class_routine
                'class_routine_read',
                'class_routine_create',
                'class_routine_update',
                'class_routine_delete',
                // attendance
                'attendance_read',
                'attendance_create',
                // Start Report
                'report_marksheet_read',
                'report_merit_list_read',
                'report_progress_card_read',
                'report_due_fees_read',
                'report_fees_collection_read',
                'report_account_read',
                'report_class_routine_read',
                'report_exam_routine_read',
                'report_attendance_read',
                // End Report
            ];
            $user->save();

            $staff                          = new Staff();
            $staff->upload_id               = $upload->id;
            $staff->user_id                 = $user->id;
            $staff->staff_id                = '100'+$i;
            $staff->role_id                 = 5;
            $staff->designation_id          = 2;
            $staff->department_id           = 2;
            $staff->first_name              = 'Teacher';
            $staff->last_name               = $i;
            $staff->father_name             = 'Teacher '.$i.' father';
            $staff->mother_name             = 'Teacher '.$i.' mother';
            $staff->email                   = 'teacher'.$i.'@gmail.com';
            $staff->gender_id               = 1;
            $staff->dob                     = '1999-01-01';
            $staff->joining_date            = '2023-01-01';
            $staff->phone                   = '014789625'.$i;
            $staff->emergency_contact       = '014789625'.$i;
            $staff->marital_status          = 1;
            $staff->status                  = 1;
            $staff->current_address         = 'Dhaka, Bangladesh';
            $staff->permanent_address       = 'Dhaka, Bangladesh';
            $staff->basic_salary            = '30000';
            $staff->upload_documents        = [];

            $staff->save();
        }
    }
}
