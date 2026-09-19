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
        Schema::create('online_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('reference_no')->nullable();
            $table->tinyInteger('payment_status')->default(0)->comment('0 = no_need, 2 = need, 1 = done');
            $table->foreignId('payslip_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('fees_assign_id')->nullable();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->foreignId('classes_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('religion_id')->nullable()->constrained('religions')->cascadeOnDelete();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->cascadeOnDelete();
            $table->string('dob')->nullable();
            $table->foreignId('student_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->tinyInteger('previous_school')->default(0);
            $table->text('previous_school_info')->nullable();
            $table->foreignId('previous_school_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_profession')->nullable();
            $table->foreignId('gurdian_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_profession')->nullable();
            $table->foreignId('father_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_profession')->nullable();
            $table->foreignId('mother_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->longText('upload_documents')->nullable();


            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('cpr_no')->nullable();
            $table->string('spoken_lang_at_home')->nullable();
            $table->string('residance_address')->nullable();
            $table->string('father_nationality')->nullable();

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
        Schema::dropIfExists('online_admissions');
    }
};
