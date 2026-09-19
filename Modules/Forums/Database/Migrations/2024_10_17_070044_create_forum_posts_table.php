<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ApprovalStatus;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('views_count')->default(0);
            $table->string('target_roles')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('upload_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);

            $table->enum('approval_status', ApprovalStatus::values())->default(ApprovalStatus::PENDING);
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->boolean('is_published')->default(0);
            $table->foreignId('published_by')->nullable();
            $table->dateTime('published_at')->nullable();

            $table->integer('rejected_by')->nullable();
            $table->integer('pending_by')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_posts');
    }
};
