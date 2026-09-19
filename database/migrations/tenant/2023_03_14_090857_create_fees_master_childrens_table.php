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
        Schema::create('fees_master_childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fees_master_id')->constrained('fees_masters')->cascadeOnDelete();
            $table->foreignId('fees_type_id')->constrained('fees_types')->cascadeOnDelete();
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
        Schema::dropIfExists('fees_master_childrens');
    }
};
