<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('students', 'siblings_discount')) {
            Schema::table('students', function (Blueprint $table) {
                $table->tinyInteger('siblings_discount')->default(Status::INACTIVE)->after('status');
            });
        }
    }

    public function down()
    {

    }
};
