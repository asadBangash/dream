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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('top_text');
            $table->longText('description');

            $table->boolean('logo_show')->default(true);
            $table->foreignId('bg_image')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->foreignId('bottom_left_signature')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->longText('bottom_left_text');

            $table->foreignId('bottom_right_signature')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->longText('bottom_right_text');

            $table->boolean('logo')->default(true);
            $table->boolean('name')->default(true);

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
        Schema::dropIfExists('certificates');
    }
};
