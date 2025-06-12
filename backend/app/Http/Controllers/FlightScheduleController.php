<?php

namespace App\Http\Controllers;

use App\Models\FlightSchedule;
use Illuminate\Http\Request;

class FlightScheduleController extends Controller
{
    public function index()
    {
        return FlightSchedule::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flightno' => 'required|string|max:8',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'departure' => 'required|date_format:H:i:s',
            'arrival' => 'required|date_format:H:i:s',
            'airline_id' => 'required|integer',
            'monday' => 'required|boolean',
            'tuesday' => 'required|boolean',
            'wednesday' => 'required|boolean',
            'thursday' => 'required|boolean',
            'friday' => 'required|boolean',
            'saturday' => 'required|boolean',
            'sunday' => 'required|boolean',
        ]);

        return FlightSchedule::create($validated);
    }

    public function show($flightno)
    {
        return FlightSchedule::where('flightno', $flightno)->firstOrFail();
    }

    public function update(Request $request, $flightno)
    {
        $schedule = FlightSchedule::where('flightno', $flightno)->firstOrFail();
        $schedule->update($request->all());
        return $schedule;
    }

    public function destroy($flightno)
    {
        FlightSchedule::where('flightno', $flightno)->delete();
        return response()->noContent();
    }
}
