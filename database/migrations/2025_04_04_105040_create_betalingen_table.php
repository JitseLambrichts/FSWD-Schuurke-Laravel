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
        Schema::create('betalingen', function (Blueprint $table) {
            $table->bigIncrements('betaling_id');
            $table->foreignId('bestelling_id')->constrained('bestellingen', 'bestelling_id')->cascadeOnDelete();
            $table->dateTime('datum');
            $table->enum('status', ['Betaald', 'Niet betaald']);
            $table->enum('betaalmethode', ['Bankcontact', 'Credit', 'Cash']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('betalingen');
    }
};
