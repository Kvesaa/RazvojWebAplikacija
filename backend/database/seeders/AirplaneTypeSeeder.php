<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AirplaneType;

class AirplaneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airplaneTypes = [
            ['identifier' => 'B737-800', 'description' => 'Boeing 737-800'],
            ['identifier' => 'A320', 'description' => 'Airbus A320'],
            ['identifier' => 'B777-300ER', 'description' => 'Boeing 777-300ER'],
            ['identifier' => 'A350-900', 'description' => 'Airbus A350-900'],
            ['identifier' => 'B787-9', 'description' => 'Boeing 787-9 Dreamliner'],
            ['identifier' => 'A380-800', 'description' => 'Airbus A380-800'],
            ['identifier' => 'B747-8', 'description' => 'Boeing 747-8'],
            ['identifier' => 'A330-300', 'description' => 'Airbus A330-300'],
            ['identifier' => 'B737-MAX8', 'description' => 'Boeing 737 MAX 8'],
            ['identifier' => 'A321neo', 'description' => 'Airbus A321neo'],
        ];

        foreach ($airplaneTypes as $type) {
            AirplaneType::create($type);
        }
    }
}
