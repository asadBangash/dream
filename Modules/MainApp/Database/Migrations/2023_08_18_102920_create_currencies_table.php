<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('code')->unique();
            $table->string('symbol');
            $table->integer('decimal_digits')->nullable()->default(2);
            $table->string('decimal_point_separator')->nullable();
            $table->string('thousand_separator')->nullable();
            $table->tinyInteger('with_space')->nullable()->default(0);
            $table->tinyInteger('position')->default(1)->comment('0 => Suffix, 1 => Prefix');
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
        Schema::dropIfExists('currencies');
    }
};
