<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('talent_test_applications')) {
            return;
        }

        Schema::create('talent_test_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 20)->nullable();
            $table->string('student_name');
            $table->string('father_name');
            $table->string('dob')->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment('1=male, 2=female');
            $table->string('contact_number');
            $table->string('guardian_contact')->nullable();
            $table->text('home_address')->nullable();
            $table->string('current_class')->nullable();
            $table->string('school_name')->nullable();
            $table->string('last_exam_marks')->nullable();
            $table->string('total_marks')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0=pending,1=reviewed,2=approved,3=rejected');
            $table->text('admin_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talent_test_applications');
    }
};
