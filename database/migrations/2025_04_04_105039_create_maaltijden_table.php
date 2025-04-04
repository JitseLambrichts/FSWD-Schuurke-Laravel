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
        Schema::create('maaltijden', function (Blueprint $table) {
            $table->bigIncrements('maaltijd_id');
            $table->string('categorie');
            $table->foreignId('gerecht_id')->unique()->constrained('gerechten', 'gerecht_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maaltijden');
    }
};
