<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->foreignId('classes_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('lecture_type', 20)->default('pdf')->comment('pdf, video, lecture');
            $table->foreignId('upload_id')->nullable()->constrained('uploads')->nullOnDelete();
            $table->string('video_url')->nullable();
            $table->tinyInteger('status')->default(Status::ACTIVE);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_lectures');
    }
};
