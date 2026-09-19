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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->foreignId('income_head')->constrained('account_heads')->cascadeOnDelete();
            $table->string('date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('amount', 16,2)->nullable(); 
            $table->foreignId('upload_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('fees_collect_id')->nullable()->constrained('fees_collects')->cascadeOnDelete();
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
        Schema::dropIfExists('incomes');
    }
};
