<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MainApp\Enums\PackagePaymentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_type', ['prepaid', 'postpaid'])->default(PackagePaymentType::PREPAID);
            $table->string('name')->nullable();
            $table->decimal('price', 16, 2)->default(0);
            $table->decimal('per_student_price', 16, 2)->default(0);
            $table->integer('student_limit')->nullable();
            $table->integer('staff_limit')->nullable();
            $table->tinyInteger('duration')->nullable();
            $table->integer('duration_number')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('popular')->default(0);
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
        Schema::dropIfExists('packages');
    }
};
