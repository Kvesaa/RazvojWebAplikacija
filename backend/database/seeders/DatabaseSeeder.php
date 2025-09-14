<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndUsersSeeder::class,
            BasicAuthUserSeeder::class,
            AirportSeeder::class,
            AirlineSeeder::class,
            AirplaneTypeSeeder::class,
            AirplaneSeeder::class,
            FlightSeeder::class,
            PassengerSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
