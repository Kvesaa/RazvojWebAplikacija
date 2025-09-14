<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = [
            ['iata' => 'AA', 'airlinename' => 'American Airlines', 'base_airport' => 1],
            ['iata' => 'BA', 'airlinename' => 'British Airways', 'base_airport' => 3],
            ['iata' => 'LH', 'airlinename' => 'Lufthansa', 'base_airport' => 5],
            ['iata' => 'AF', 'airlinename' => 'Air France', 'base_airport' => 4],
            ['iata' => 'JL', 'airlinename' => 'Japan Airlines', 'base_airport' => 6],
            ['iata' => 'QF', 'airlinename' => 'Qantas', 'base_airport' => 7],
            ['iata' => 'EK', 'airlinename' => 'Emirates', 'base_airport' => 8],
            ['iata' => 'SQ', 'airlinename' => 'Singapore Airlines', 'base_airport' => 9],
            ['iata' => 'KE', 'airlinename' => 'Korean Air', 'base_airport' => 10],
            ['iata' => 'DL', 'airlinename' => 'Delta Air Lines', 'base_airport' => 2],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}