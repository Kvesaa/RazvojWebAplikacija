<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Passenger;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passengers = [
            ['passportno' => 'HR1234567', 'firstname' => 'Ivica', 'lastname' => 'Ivić'],
            ['passportno' => 'HR2345678', 'firstname' => 'Ana', 'lastname' => 'Anić'],
            ['passportno' => 'HR3456789', 'firstname' => 'Ivan', 'lastname' => 'Fitilj'],
            ['passportno' => 'HR4567890', 'firstname' => 'Jozo', 'lastname' => 'Jozić'],
            ['passportno' => 'HR5678901', 'firstname' => 'Danica', 'lastname' => 'Rezić'],
            ['passportno' => 'US1234567', 'firstname' => 'John', 'lastname' => 'Doe'],
            ['passportno' => 'US2345678', 'firstname' => 'Jane', 'lastname' => 'Doe'],
        ];

        foreach ($passengers as $passenger) {
            Passenger::create($passenger);
        }
    }
}
