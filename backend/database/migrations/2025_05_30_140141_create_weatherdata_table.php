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
        Schema::create('weatherdata', function (Blueprint $table) {
            $table->dateTime('log_date');
            $table->time('time');
            $table->string('station', 11);
            $table->decimal('temp', 4, 1);
            $table->decimal('humidity', 4, 1);
            $table->decimal('airpressure', 10, 2);
            $table->decimal('windspeed', 4, 1);
            $table->enum('weather', ['sunny', 'rain', 'snow', 'fog', 'storm']);
            $table->smallInteger('winddirection');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weatherdata');
    }
};
