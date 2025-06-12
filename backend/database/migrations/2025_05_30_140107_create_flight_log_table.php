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
        Schema::create('flight_log', function (Blueprint $table) {
            $table->bigIncrements('flight_log_id');
            $table->dateTime('log_date');
            $table->string('user', 100);
            $table->char('flightno', 8);
            $table->smallInteger('from_old');
            $table->smallInteger('to_old');
            $table->smallInteger('from_new');
            $table->smallInteger('to_new');
            $table->dateTime('departure_old');
            $table->dateTime('arrival_old');
            $table->dateTime('departure_new');
            $table->dateTime('arrival_new');
            $table->unsignedInteger('airplane_id_old');
            $table->unsignedInteger('airplane_id_new');
            $table->smallInteger('airline_id_old');
            $table->smallInteger('airline_id_new');
            $table->string('comment', 200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_log');
    }
};
