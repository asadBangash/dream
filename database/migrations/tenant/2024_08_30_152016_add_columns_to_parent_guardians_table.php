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
        Schema::table('parent_guardians', function (Blueprint $table) {
            // Check if 'father_id' column does not exist in 'parent_guardians' table
            if (!Schema::hasColumn('parent_guardians', 'father_id')) {
                $table->string('father_id')->nullable();
            }

            // Check if 'mother_id' column does not exist in 'parent_guardians' table
            if (!Schema::hasColumn('parent_guardians', 'mother_id')) {
                $table->string('mother_id')->nullable();
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
        Schema::table('parent_guardians', function (Blueprint $table) {
            // Drop columns if they exist during rollback
            if (Schema::hasColumn('parent_guardians', 'father_id')) {
                $table->dropColumn('father_id');
            }

            if (Schema::hasColumn('parent_guardians', 'mother_id')) {
                $table->dropColumn('mother_id');
            }
        });
    }
};
