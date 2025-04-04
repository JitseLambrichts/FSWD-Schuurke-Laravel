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
        Schema::create('suggesties', function (Blueprint $table) {
            $table->bigIncrements('suggestie_id');
            $table->string('periode');
            $table->foreignId('gerecht_id')->constrained('gerechten', 'gerecht_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggesties');
    }
};
