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
        Schema::create('exam_assign_childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_assign_id')->constrained('exam_assigns')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->float('mark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_assign_childrens');
    }
};
