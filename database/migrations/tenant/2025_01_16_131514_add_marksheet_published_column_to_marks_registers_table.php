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
        Schema::table('marks_registers', function (Blueprint $table) {
            if (!Schema::hasColumn('marks_registers', 'is_marksheet_published')) {
                $table->boolean('is_marksheet_published')->default(0)->after('subject_id');
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
        Schema::table('marks_registers', function (Blueprint $table) {
            if (Schema::hasColumn('marks_registers', 'is_marksheet_published')) {
                $table->dropColumn('is_marksheet_published');
            }
        });
    }
};
