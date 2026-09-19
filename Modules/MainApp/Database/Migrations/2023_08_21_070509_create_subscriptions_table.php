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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->foreignId('school_id')->nullable()->constrained('schools')->cascadeOnDelete();
            $table->decimal('price', 16, 2)->nullable()->default(0);
            $table->integer('student_limit')->nullable()->default(0);
            $table->integer('staff_limit')->nullable()->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('method')->nullable();
            $table->longText('features_name')->nullable();
            $table->longText('features')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = approved, 2 = reject');
            $table->tinyInteger('payment_status')->default(1)->comment('0 = unpaid, 1 = paid');
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
