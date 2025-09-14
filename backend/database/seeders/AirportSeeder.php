<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            ['iata' => 'JFK', 'icao' => 'KJFK', 'name' => 'John F. Kennedy International Airport'],
            ['iata' => 'LAX', 'icao' => 'KLAX', 'name' => 'Los Angeles International Airport'],
            ['iata' => 'LHR', 'icao' => 'EGLL', 'name' => 'London Heathrow Airport'],
            ['iata' => 'CDG', 'icao' => 'LFPG', 'name' => 'Charles de Gaulle Airport'],
            ['iata' => 'FRA', 'icao' => 'EDDF', 'name' => 'Frankfurt Airport'],
            ['iata' => 'NRT', 'icao' => 'RJAA', 'name' => 'Narita International Airport'],
            ['iata' => 'SYD', 'icao' => 'YSSY', 'name' => 'Sydney Kingsford Smith Airport'],
            ['iata' => 'DXB', 'icao' => 'OMDB', 'name' => 'Dubai International Airport'],
            ['iata' => 'SIN', 'icao' => 'WSSS', 'name' => 'Singapore Changi Airport'],
            ['iata' => 'ICN', 'icao' => 'RKSI', 'name' => 'Incheon International Airport'],
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}