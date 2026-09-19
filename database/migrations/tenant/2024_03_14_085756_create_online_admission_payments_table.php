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
        Schema::create('online_admission_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->unsigned();
            $table->date('date')->nullable();
            $table->tinyInteger('payment_method')->nullable();
            $table->foreignId('fees_assign_id')->unsigned();
            $table->decimal('amount', 16,2)->nullable();
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
        Schema::dropIfExists('online_admission_payments');
    }
};
