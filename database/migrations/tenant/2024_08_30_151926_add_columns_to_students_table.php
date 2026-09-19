<?php

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
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'student_ar_name')) {
                $table->string('student_ar_name')->nullable();
            }

            if (!Schema::hasColumn('students', 'student_id_certificate')) {
                $table->string('student_id_certificate')->nullable();
            }

            if (!Schema::hasColumn('students', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable();
            }

            if (!Schema::hasColumn('students', 'student_code')) {
                $table->string('student_code')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'student_ar_name')) {
                $table->dropColumn('student_ar_name');
            }

            if (Schema::hasColumn('students', 'student_id_certificate')) {
                $table->dropColumn('student_id_certificate');
            }

            if (Schema::hasColumn('students', 'emergency_contact')) {
                $table->dropColumn('emergency_contact');
            }

            if (Schema::hasColumn('students', 'student_code')) {
                $table->dropColumn('student_code');
            }
        });
    }
};
