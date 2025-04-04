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
        Schema::create('bestelling_bevat_gerechten', function (Blueprint $table) {
            $table->foreignId('bestelling_id')->constrained('bestellingen', 'bestelling_id')->cascadeOnDelete();
            $table->foreignId('gerecht_id')->constrained('gerechten', 'gerecht_id')->cascadeOnDelete();
            $table->integer('aantal')->default(1);
            $table->primary(['bestelling_id', 'gerecht_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bestelling_bevat_gerechten');
    }
};
