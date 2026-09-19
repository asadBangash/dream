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
        Schema::create('fees_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions')->cascadeOnDelete();
            $table->foreignId('fees_group_id')->constrained('fees_groups')->cascadeOnDelete();
            $table->foreignId('fees_type_id')->constrained('fees_types')->cascadeOnDelete();
            $table->date('due_date')->nullable();
            $table->decimal('amount', 16,2)->default(0)->nullable();
            $table->tinyInteger('fine_type')->default(App\Enums\FineType::NONE)->comment('0 = none, 1 = percentage, 2 = fixed');
            $table->integer('percentage')->default(0)->nullable();
            $table->decimal('fine_amount', 16,2)->default(0)->nullable();
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
        Schema::dropIfExists('fees_masters');
    }
};
