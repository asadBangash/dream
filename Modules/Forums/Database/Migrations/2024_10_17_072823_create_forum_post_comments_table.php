<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_post_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->foreignId('parent_id')->nullable()->constrained('forum_post_comments')->cascadeOnDelete();
            $table->foreignId('forum_post_id')->constrained('forum_posts')->cascadeOnDelete();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);
            $table->boolean('is_published')->default(1);
            $table->integer('approved_by')->nullable();
            $table->foreignId('published_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_post_comments');
    }
};
