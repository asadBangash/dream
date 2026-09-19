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
            if (!Schema::hasColumns('students', ['health_status', 'rank_in_family', 'siblings'])) {
                $table->string('health_status')->after('nationality')->nullable();
                $table->integer('rank_in_family')->after('health_status')->default(1);
                $table->integer('siblings')->after('rank_in_family')->default(0);
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
            if (Schema::hasColumn('students', 'health_status')) {
                $table->dropColumn('health_status');
            }
            if (Schema::hasColumn('students', 'rank_in_family')) {
                $table->dropColumn('rank_in_family');
            }
            if (Schema::hasColumn('students', 'siblings')) {
                $table->dropColumn('siblings');
            }
        });
    }

};
