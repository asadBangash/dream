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
        Schema::create('gmeets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('gmeet_link');
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->foreignId('classes_id')->nullable()->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->cascadeOnDelete();

            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();

            $table->string('status')->default(App\Enums\GmeetStatus::PENDING);
            $table->text('description');
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
        Schema::dropIfExists('gmeets');
    }
};
