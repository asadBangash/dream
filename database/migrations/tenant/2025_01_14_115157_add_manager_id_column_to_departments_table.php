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
        Schema::table('departments', function (Blueprint $table) {
            // add manager_id column if does not exist
            if (!Schema::hasColumn('departments', 'staff_user_id')) {
                $table->foreignId('staff_user_id')->after('name')->nullable()->constrained('users');
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
        Schema::table('departments', function (Blueprint $table) {
            //
            if (Schema::hasColumn('departments', 'staff_user_id')) {
                $table->dropColumn('staff_user_id');
            }
        });
    }
};
