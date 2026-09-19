<?php

use App\Models\Fees\FeesAssignChildren;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assign_fees_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FeesAssignChildren::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->double('discount_amount');
            $table->double('discount_percentage');
            $table->string('discount_source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_fees_discounts');
    }
};
