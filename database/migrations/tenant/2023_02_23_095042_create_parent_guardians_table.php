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
        Schema::create('parent_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('father_name')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('father_profession')->nullable();
            $table->string('father_image')->nullable();
            $table->string('father_nationality')->nullable();

            $table->string('mother_name')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->string('mother_profession')->nullable();
            $table->string('mother_image')->nullable();

            $table->string('guardian_name')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_mobile')->nullable();
            $table->string('guardian_image')->nullable();

            $table->string('guardian_profession')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_address')->nullable();

            $table->string('guardian_place_of_work')->nullable();
            $table->string('guardian_position')->nullable();

            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);
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
        Schema::dropIfExists('parent_guardians');
    }
};
