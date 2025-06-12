<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_id' => 'required|integer',
            'seat' => 'required|string|max:4',
            'passenger_id' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        return Booking::create($validated);
    }

    public function show($id)
    {
        return Booking::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return $booking;
    }

    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->noContent();
    }
}
