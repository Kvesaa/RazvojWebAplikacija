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
        Schema::create('airplane', function (Blueprint $table) {
            $table->increments('airplane_id');
            $table->mediumInteger('capacity');
            $table->unsignedInteger('type_id');
            $table->smallInteger('airline_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airplane');
    }
};
