<?php

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->string('host')->nullable()->comment('e=email, s=SMS, w=web, a=app');
            $table->string('reciever')->nullable();
            $table->string('subject')->nullable();
            $table->longText('template')->nullable();
            $table->text('shortcode')->nullable();
            $table->timestamps();
        });

        $events = [
            //Student_Attendance
            [
                'event' => 'Student_Attendance',
                'host' => [
                    "email" => 1,
                    "sms" => 1,
                    "web" => 1,
                    "app" => 1
                ],
                'reciever' => [
                    "Student" => 1,
                    "Parent" => 1
                ],
                'subject' => [
                    "Student"=> "Student Attendance" ,
                    "Parent"=> "Student Attendance"
                ],

                'template' => [
                    "Student" => [
                        "Email" => "Dear [student_name],
                        Your attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                        "SMS" => "Dear [student_name],
                        Your attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                        "Web" => "Dear [student_name],
                        Your attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                        "App" => "Dear [student_name],
                        Your attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                    ],
                    "Parent"=> [
                        "Email" => "Dear [parent_name],
                        Your child's attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                        "SMS" => "Dear [parent_name],
                        Your child's attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name]." ,
                        "Web" => "Dear [parent_name],
                        Your child's attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                        "App" => "Dear [parent_name],
                        Your child's attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                    ],
                ],

                'shortcode' => [
                    "Student" => "[student_name], [class], [section], [admission_no], [roll_no], [attendance_type], [attendance_date], [school_name]",
                    "Parent" => "[guardian_name], [student_name], [class], [section], [admission_no], [roll_no], [attendance_type], [attendance_date], [school_name]"
                ]
            ],

            [
                'event' => 'Online_Admission',
                'host' => [
                    "email" => 1,
                    "sms" => 1,
                    "web" => 1,
                    "app" => 1
                ],
                'reciever' => [
                    "Super Admin" => 1,
                    "Student" => 1,
                    "Parent" => 1
                ],
                'subject' => [
                    "Super Admin"=> "Student Online Admission" ,
                    "Student"=> "Student Online Admission",
                    "Parent"=> "Student Online Admission"
                ],

                'template' => [
                    "Super Admin" => [
                        "Email" => "Dear Super Admin,
                         [student_name] admitted on class : [class] , section : [section] on [admission_date]. Thank You [school_name] ." ,
                        "SMS" => "Dear Super Admin,
                        [student_name] admitted on class : [class] , section : [section] on [admission_date]. Thank You [school_name] ." ,
                        "Web" => "Dear Super Admin,
                        [student_name] admitted on class : [class] , section : [section] on [admission_date]. Thank You [school_name] ." ,
                        "App" => "Dear Super Admin,
                        [student_name] admitted on class : [class] , section : [section] on [admission_date]. Thank You [school_name] ." ,
                    ],
                    "Student" => [
                        "Email" => "Dear [student_name],
                        You are admitted on class : [class] , section : [section] , Admission No : [admission_no] on [school_name]. Login Username : [student_email] , Default Password : 123456 Thank You for choosing [school_name] ." ,
                        "SMS" => "Dear [student_name],
                        You are admitted on class : [class] , section : [section] , Admission No : [admission_no] on [school_name]. Login Username : [student_email]  , Default Password : 123456 Thank You for choosing [school_name] ." ,
                        "Web" => "You are admitted on class : [class] , section : [section] , Admission No : [admission_no] on [school_name]." ,
                        "App" => "Dear [student_name],
                        Your attendance was listed [attendance_type] on [attendance_date] for Class: [class], Section: [section]. Thank You [school_name] ." ,
                    ],
                    "Parent"=> [
                        "Email" => "Dear [parent_name],
                        Your child [student_name] admitted on class : [class] , section : [section] , Admission No : [admission_no] on [school_name]. Login Username : [parent_email]  , Default Password : 123456 Thank You for choosing [school_name]" ,
                        "SMS" => "Dear [parent_name],
                        Your child [student_name] admitted on class : [class] , section : [section] , Admission No : [admission_no] on [school_name]. Login Username : [parent_email]  , Default Password : 123456 Thank You for choosing [school_name]" ,
                        "Web" => "Dear [parent_name],
                        Your child [student_name] admitted on class : [class_name] , section : [section_name] , Admission No : [admission_no] on [school_name]. Login Username : [parent_email]  , Default Password : 123456 Thank You for choosing [school_name]" ,
                        "App" => " Your child [student_name] admitted on class : [class_name] , section : [section_name] , Admission No : [admission_no] on [school_name]. Login Username : [parent_email] , Default Password : 123456 Thank You for choosing [school_name]" ,
                    ],
                ],

                'shortcode' => [
                    "Super Admin" => "[student_name], [class], [section], [admission_no], [admission_date], [school_name]",
                    "Student" => "[parent_name], [student_name], [class], [section], [admission_no], [student_email], [phone] , [school_name]",
                    "Parent" => "[parent_name], [student_name], [class], [section], [admission_no], [parent_email], [phone] , [school_name]"
                ]
            ],
        ];

        foreach($events as $event){
            $newEvent = new NotificationSetting();
                $newEvent->event = $event['event'];
                $newEvent->host = $event['host'];
                $newEvent->reciever = $event['reciever'];
                $newEvent->subject = $event['subject'];
                $newEvent->template = $event['template'];
                $newEvent->shortcode = $event['shortcode'];
                $newEvent->save();
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
};
