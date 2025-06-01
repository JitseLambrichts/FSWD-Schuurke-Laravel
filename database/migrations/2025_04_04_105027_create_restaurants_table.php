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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('restaurant_id');
            $table->string('naam');
            $table->string('telefoonnummer', 50);
            $table->string('email');
            $table->text('openingsuren');   //Verschil tussen string en text -> text is lang en geen limiet terwijl string een lim heeft van 255
            $table->timestamps();                   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
