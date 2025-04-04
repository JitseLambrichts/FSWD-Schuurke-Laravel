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
        Schema::create('dranken', function (Blueprint $table) {
            $table->bigIncrements('drank_id');
            $table->float('volume')->nullable(); // Volume kan soms onbekend zijn (bv glas)
            $table->float('alcohol_percentage')->nullable();
            $table->foreignId('gerecht_id')->unique()->constrained('gerechten', 'gerecht_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dranken');
    }
};
