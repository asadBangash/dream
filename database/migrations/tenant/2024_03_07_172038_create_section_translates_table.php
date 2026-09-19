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
        Schema::create('section_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->nullable()->constrained('page_sections')->cascadeOnDelete();
            $table->string('locale')->default('en');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('section_translates');
    }
};
