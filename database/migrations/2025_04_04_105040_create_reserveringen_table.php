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
        Schema::create('reserveringen', function (Blueprint $table) {
            $table->bigIncrements('reservering_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('datum');
            $table->time('tijdstip');
            $table->integer('tafelnummer');
            $table->integer('aantal_personen');
            $table->text('speciale_verzoeken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserveringen');
    }
};
