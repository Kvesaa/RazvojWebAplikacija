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
        Schema::create('passengerdetails', function (Blueprint $table) {
            $table->bigInteger('passenger_id')->primary();
            $table->date('birthdate');
            $table->char('sex', 1);
            $table->string('street', 100);
            $table->string('city', 100);
            $table->smallInteger('zip');
            $table->string('country', 120);
            $table->string('emailaddress', 120);
            $table->string('telephone', 30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengerdetails');
    }
};
