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
        Schema::create('memory_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_id')->nullable()->constrained('memories')->cascadeOnDelete();
            $table->foreignId('gallery_image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memory_galleries');
    }
};
