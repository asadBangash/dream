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
        Schema::create('id_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('expired_date')->nullable();
            $table->foreignId('frontside_bg_image')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('backside_bg_image')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('signature')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('qr_code')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->text('backside_description')->nullable();
            $table->boolean('student_name')->default(true);
            $table->boolean('admission_no')->default(true);
            $table->boolean('roll_no')->default(true);
            $table->boolean('class_name')->default(true);
            $table->boolean('section_name')->default(true);
            $table->boolean('blood_group')->default(true);
            $table->boolean('dob')->default(true);
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
        Schema::dropIfExists('id_cards');
    }
};
