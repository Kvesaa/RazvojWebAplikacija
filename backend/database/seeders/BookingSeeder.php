<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [
            [
                'booking_id' => 1,
                'passenger_id' => 1,
                'flight_id' => 1,
                'seat' => '12A',
                'price' => 299.99
            ],
            [
                'booking_id' => 2,
                'passenger_id' => 2,
                'flight_id' => 2,
                'seat' => '8B',
                'price' => 450.00
            ],
            [
                'booking_id' => 3,
                'passenger_id' => 3,
                'flight_id' => 3,
                'seat' => '15C',
                'price' => 675.50
            ],
            [
                'booking_id' => 4,
                'passenger_id' => 4,
                'flight_id' => 4,
                'seat' => '3A',
                'price' => 425.75
            ],
            [
                'booking_id' => 5,
                'passenger_id' => 5,
                'flight_id' => 5,
                'seat' => '22D',
                'price' => 850.00
            ],
            [
                'booking_id' => 6,
                'passenger_id' => 6,
                'flight_id' => 6,
                'seat' => '7B',
                'price' => 1200.00
            ],
            [
                'booking_id' => 7,
                'passenger_id' => 7,
                'flight_id' => 7,
                'seat' => '18A',
                'price' => 950.25
            ],
            [
                'booking_id' => 8,
                'passenger_id' => 1,
                'flight_id' => 8,
                'seat' => '5C',
                'price' => 750.00
            ],
            [
                'booking_id' => 9,
                'passenger_id' => 2,
                'flight_id' => 9,
                'seat' => '14B',
                'price' => 625.50
            ],
            [
                'booking_id' => 10,
                'passenger_id' => 3,
                'flight_id' => 10,
                'seat' => '9A',
                'price' => 375.00
            ],
        ];

        foreach ($bookings as $booking) {
            DB::table('booking')->insert($booking);
        }
    }
}
