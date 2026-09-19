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
        Schema::create('fees_collects', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->tinyInteger('payment_method')->nullable();
            $table->foreignId('fees_assign_children_id')->constrained('fees_assign_childrens')->cascadeOnDelete();
            $table->foreignId('fees_collect_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->decimal('amount', 16,2)->nullable()->comment('total amount + fine');
            $table->decimal('fine_amount', 16,2)->nullable();
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
        Schema::dropIfExists('fees_collects');
    }
};
