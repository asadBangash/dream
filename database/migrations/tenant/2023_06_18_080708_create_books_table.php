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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('book_categories')->cascadeOnDelete();
            $table->string('code');
            $table->string('publisher_name');
            $table->string('author_name');
            $table->integer('rack_no');
            $table->string('price');
            $table->integer('quantity');
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);
            $table->text('description');
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
        Schema::dropIfExists('books');
    }
};
