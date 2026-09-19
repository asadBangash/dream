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
        Schema::create('counter_translates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counter_id')->nullable()->constrained('counters')->cascadeOnDelete();
            $table->string('locale')->default('en');
            $table->string('name')->nullable();
            $table->string('total_count')->nullable();
            $table->string('serial')->nullable();
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
        Schema::dropIfExists('counter_translates');
    }
};
