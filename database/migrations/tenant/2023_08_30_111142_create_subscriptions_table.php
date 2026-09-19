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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_type', ['prepaid', 'postpaid'])->default('prepaid');
            $table->string('name')->nullable();
            $table->integer('price')->nullable();
            $table->integer('student_limit')->nullable();
            $table->integer('staff_limit')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('method')->nullable();
            $table->longText('features_name')->nullable();
            $table->longText('features')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = inactive, 1 = active');
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
        Schema::dropIfExists('subscriptions');
    }
};
