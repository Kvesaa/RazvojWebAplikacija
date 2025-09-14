<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airplane;

class AirplaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airplanes = [
            ['capacity' => 162, 'type_id' => 1, 'airline_id' => 1], // Boeing 737-800, American Airlines
            ['capacity' => 150, 'type_id' => 2, 'airline_id' => 2], // Airbus A320, British Airways
            ['capacity' => 396, 'type_id' => 3, 'airline_id' => 3], // Boeing 777-300ER, Lufthansa
            ['capacity' => 315, 'type_id' => 4, 'airline_id' => 4], // Airbus A350-900, Air France
            ['capacity' => 290, 'type_id' => 5, 'airline_id' => 5], // Boeing 787-9 Dreamliner, Japan Airlines
            ['capacity' => 525, 'type_id' => 6, 'airline_id' => 6], // Airbus A380-800, Qantas
            ['capacity' => 467, 'type_id' => 7, 'airline_id' => 7], // Boeing 747-8, Emirates
            ['capacity' => 277, 'type_id' => 8, 'airline_id' => 8], // Airbus A330-300, Singapore Airlines
            ['capacity' => 178, 'type_id' => 9, 'airline_id' => 9], // Boeing 737 MAX 8, Korean Air
            ['capacity' => 194, 'type_id' => 10, 'airline_id' => 10], // Airbus A321neo, Delta Air Lines
        ];

        foreach ($airplanes as $airplane) {
            Airplane::create($airplane);
        }
    }
}