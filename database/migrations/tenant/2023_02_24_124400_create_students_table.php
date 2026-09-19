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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->nullable();
            $table->integer('roll_no')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->date('admission_date')->nullable();
            $table->foreignId('student_category_id')->nullable();
            $table->foreignId('religion_id')->nullable()->constrained('religions')->cascadeOnDelete();
            $table->foreignId('blood_group_id')->nullable()->constrained('blood_groups')->cascadeOnDelete();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('student_categories')->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('parent_guardian_id')->nullable()->constrained('parent_guardians')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->longText('upload_documents')->nullable();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);
            $table->tinyInteger('siblings_discount')->default(\App\Enums\Status::INACTIVE);

            $table->tinyInteger('previous_school')->default(0);
            $table->text('previous_school_info')->nullable();
            $table->foreignId('previous_school_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->string('health_status')->nullable();
            $table->integer('rank_in_family')->default(1);
            $table->integer('siblings')->default(0);

            $table->string('place_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('cpr_no')->nullable();
            $table->string('spoken_lang_at_home')->nullable();
            $table->string('residance_address')->nullable();

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
        Schema::dropIfExists('students');
    }
};
