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
        Schema::create('airline', function (Blueprint $table) {
            $table->smallIncrements('airline_id');
            $table->char('iata', 2);
            $table->string('airlinename', 30);
            $table->smallInteger('base_airport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline');
    }
};
