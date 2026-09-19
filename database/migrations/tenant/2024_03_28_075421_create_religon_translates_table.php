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
        Schema::create('religon_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('religion_id')->nullable()->constrained('religions')->cascadeOnDelete();
            $table->string('locale')->default('en');
            $table->string('name')->nullable();
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
        Schema::dropIfExists('religon_translates');
    }
};
