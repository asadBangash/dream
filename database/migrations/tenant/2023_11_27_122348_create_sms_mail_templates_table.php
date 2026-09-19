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
        Schema::create('sms_mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['mail', 'sms']);
            $table->foreignId('attachment')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->longText('mail_description')->nullable();
            $table->text('sms_description')->nullable();
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
        Schema::dropIfExists('sms_mail_templates');
    }
};
