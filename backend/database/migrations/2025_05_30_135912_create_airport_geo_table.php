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
        Schema::create('airport_geo', function (Blueprint $table) {
            $table->smallIncrements('airport_id');
            $table->string('name', 50);
            $table->string('city', 50);
            $table->string('country', 50);
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->point('geolocation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_geo');
    }
};
