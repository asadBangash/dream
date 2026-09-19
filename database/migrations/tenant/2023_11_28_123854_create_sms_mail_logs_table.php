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
        Schema::create('sms_mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['mail', 'sms']);
            $table->longText('mail_description')->nullable();
            $table->text('sms_description')->nullable();

            $table->enum('user_type', ['role', 'individual', 'class']);

            $table->longText('role_ids')->nullable();

            $table->integer('role_id')->nullable();
            $table->longText('individual_user_ids')->nullable();

            $table->integer('class_id')->nullable();
            $table->longText('section_ids')->nullable();



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
        Schema::dropIfExists('sms_mail_logs');
    }
};
