<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = [
            [
                'flightno' => 'AA123',
                'from' => 1, // JFK
                'to' => 2,   // LAX
                'departure' => '2024-01-15 08:00:00',
                'arrival' => '2024-01-15 11:30:00',
                'airline_id' => 1, // American Airlines
                'airplane_id' => 1  // Boeing 737-800
            ],
            [
                'flightno' => 'BA456',
                'from' => 3, // LHR
                'to' => 4,   // CDG
                'departure' => '2024-01-15 14:00:00',
                'arrival' => '2024-01-15 16:30:00',
                'airline_id' => 2, // British Airways
                'airplane_id' => 2  // Airbus A320
            ],
            [
                'flightno' => 'LH789',
                'from' => 5, // FRA
                'to' => 6,   // NRT
                'departure' => '2024-01-16 10:00:00',
                'arrival' => '2024-01-16 18:30:00',
                'airline_id' => 3, // Lufthansa
                'airplane_id' => 3  // Boeing 777-300ER
            ],
            [
                'flightno' => 'AF321',
                'from' => 4, // CDG
                'to' => 7,   // SYD
                'departure' => '2024-01-16 22:00:00',
                'arrival' => '2024-01-17 12:00:00',
                'airline_id' => 4, // Air France
                'airplane_id' => 4  // Airbus A350-900
            ],
            [
                'flightno' => 'JL654',
                'from' => 6, // NRT
                'to' => 8,   // DXB
                'departure' => '2024-01-17 09:00:00',
                'arrival' => '2024-01-17 15:30:00',
                'airline_id' => 5, // Japan Airlines
                'airplane_id' => 5  // Boeing 787-9 Dreamliner
            ],
            [
                'flightno' => 'QF987',
                'from' => 7, // SYD
                'to' => 9,   // SIN
                'departure' => '2024-01-17 16:00:00',
                'arrival' => '2024-01-17 20:30:00',
                'airline_id' => 6, // Qantas
                'airplane_id' => 6  // Airbus A380-800
            ],
            [
                'flightno' => 'EK147',
                'from' => 8, // DXB
                'to' => 1,   // JFK
                'departure' => '2024-01-18 02:00:00',
                'arrival' => '2024-01-18 08:30:00',
                'airline_id' => 7, // Emirates
                'airplane_id' => 7  // Boeing 747-8
            ],
            [
                'flightno' => 'SQ258',
                'from' => 9, // SIN
                'to' => 10,  // ICN
                'departure' => '2024-01-18 11:00:00',
                'arrival' => '2024-01-18 16:30:00',
                'airline_id' => 8, // Singapore Airlines
                'airplane_id' => 8  // Airbus A330-300
            ],
            [
                'flightno' => 'KE369',
                'from' => 10, // ICN
                'to' => 3,    // LHR
                'departure' => '2024-01-18 18:00:00',
                'arrival' => '2024-01-19 06:30:00',
                'airline_id' => 9, // Korean Air
                'airplane_id' => 9  // Boeing 737 MAX 8
            ],
            [
                'flightno' => 'DL741',
                'from' => 2, // LAX
                'to' => 5,   // FRA
                'departure' => '2024-01-19 13:00:00',
                'arrival' => '2024-01-20 08:30:00',
                'airline_id' => 10, // Delta Air Lines
                'airplane_id' => 10 // Airbus A321neo
            ],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}