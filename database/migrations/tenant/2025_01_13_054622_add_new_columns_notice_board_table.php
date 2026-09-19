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
        Schema::table('notice_boards', function (Blueprint $table) {
            // Add `class_id` if it doesn't exist
            if (!Schema::hasColumn('notice_boards', 'session_id')) {
                $table->unsignedBigInteger('session_id')->default(setting('session_id'))->nullable()->after('title');
            }
            if (!Schema::hasColumn('notice_boards', 'class_id')) {
                $table->unsignedBigInteger('class_id')->nullable()->after('session_id');
            }

            // Add `section_id` if it doesn't exist
            if (!Schema::hasColumn('notice_boards', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('class_id');
            }

            // Add `student_id` if it doesn't exist
            if (!Schema::hasColumn('notice_boards', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->after('section_id');
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
        Schema::table('notice_boards', function (Blueprint $table) {
            if (Schema::hasColumn('notice_boards', 'session_id')) {
                $table->dropColumn('session_id');
            }
            if (Schema::hasColumn('notice_boards', 'class_id')) {
                $table->dropColumn('class_id');
            }

            if (Schema::hasColumn('notice_boards', 'section_id')) {
                $table->dropColumn('section_id');
            }

            if (Schema::hasColumn('notice_boards', 'student_id')) {
                $table->dropColumn('student_id');
            }
        });
    }
};
