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
            //add department_id column to students table if not exists 
            if (!Schema::hasColumn('students', 'department_id')) {
                $table->foreignId('department_id')->after('dob')->nullable()->constrained('departments');
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
            //drop department_id column from students table if exists
            if (Schema::hasColumn('students', 'department_id')) {
                $table->dropColumn('department_id');
            }
        });
    }
};
