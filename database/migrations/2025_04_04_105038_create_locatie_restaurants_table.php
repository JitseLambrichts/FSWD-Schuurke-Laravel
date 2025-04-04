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
        Schema::create('locatie_restaurants', function (Blueprint $table) {
            $table->bigIncrements('locatie_id');
            $table->string('straat');
            $table->string('gemeente');
            $table->foreignId('restaurant_id')->constrained('restaurants', 'restaurant_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locatie_restaurants');
    }
};
