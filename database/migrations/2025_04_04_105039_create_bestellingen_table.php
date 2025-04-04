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
        Schema::create('bestellingen', function (Blueprint $table) {
            $table->bigIncrements('bestelling_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['In winkelwagen', 'Besteld', 'Afgehaald']);
            $table->decimal('totaalprijs', 10, 2);
            $table->dateTime('afhaaltijdstip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bestellingen');
    }
};
