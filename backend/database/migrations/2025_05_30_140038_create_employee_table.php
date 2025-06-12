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
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->date('birthdate');
            $table->char('sex', 1);
            $table->string('street', 100);
            $table->smallInteger('zip');
            $table->string('city', 100);
            $table->string('emailaddress', 120);
            $table->string('telephone', 30);
            $table->decimal('salary', 8, 2);
            $table->string('username', 20);
            $table->char('password', 32);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
