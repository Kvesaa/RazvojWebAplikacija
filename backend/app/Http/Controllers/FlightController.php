<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        return Flight::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flightno' => 'required|string|max:8',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'departure' => 'required|date',
            'arrival' => 'required|date',
            'airline_id' => 'required|integer',
            'airplane_id' => 'required|integer',
        ]);

        return Flight::create($validated);
    }

    public function show($id)
    {
        return Flight::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $flight->update($request->all());
        return $flight;
    }

    public function destroy($id)
    {
        Flight::destroy($id);
        return response()->noContent();
    }
}
