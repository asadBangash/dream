<?php

use App\Models\StudentAbsentNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_absent_notifications', function (Blueprint $table) {
            $table->id();
            $table->boolean('notify_student')->default(false);
            $table->boolean('notify_gurdian')->default(true);
            $table->string('sending_time');
            $table->boolean('active_status')->default(true);
            $table->text('notification_message')->nullable();
            $table->timestamps();
        });

        $data = new StudentAbsentNotification();
        $data->sending_time = '10:00'; 
        $data->notification_message = 'Hi [guardian_name] , your child [student_name] on class [class] - ([section]) Admission [admission_no] is [attendance_type] on [attendance_date]  . For more contact [school_name]' ;
        $data->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_absent_notifications');
    }
};
