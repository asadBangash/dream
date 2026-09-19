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
            if (!Schema::hasColumns('parent_guardians', ['guardian_place_of_work', 'guardian_position'])){
                $table->string('guardian_place_of_work')->nullable();
                $table->string('guardian_position')->nullable();
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
            if (Schema::hasColumn('parent_guardians', 'guardian_place_of_work')){
                $table->string('guardian_place_of_work')->nullable();
            }

            if (Schema::hasColumn('parent_guardians', 'guardian_position')){
                $table->string('guardian_position')->nullable();
            }
        });
    }
};
