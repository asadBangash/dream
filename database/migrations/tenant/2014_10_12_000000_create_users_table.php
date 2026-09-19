<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('admission_no')->nullable()->comment('For student login');
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->default(App\Enums\Gender::MALE);
            $table->timestamp('email_verified_at')->nullable()->comment('if null then verifield, not null then not verified');
            $table->string('token')->nullable()->comment('Token for email/phone verification, if null then verifield, not null then not verified');
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('permissions')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);

            $table->unsignedBigInteger('branch_id')->default(1);

            $table->unsignedBigInteger('upload_id')->nullable();
            $table->foreign('upload_id')->references('id')->on('uploads')->onDelete('set null');

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

            $table->unsignedBigInteger('designation_id')->nullable();
            $table->uuid('uuid')->nullable();
            $table->longText('device_token')->nullable()->comment('device_token from firebase');
            $table->rememberToken();
            $table->string('reset_password_otp')->nullable();
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
        Schema::dropIfExists('users');
    }
};
