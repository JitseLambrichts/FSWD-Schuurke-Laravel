<?php

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
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('review_id');
            $table->foreignId('user_id');
            $table->foreignId('gerecht_id')->constrained('gerechten', 'gerecht_id')->cascadeOnDelete();
            $table->tinyInteger('score'); // Score van 1-5
            $table->text('extra_info')->nullable();
            $table->dateTime('datum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
