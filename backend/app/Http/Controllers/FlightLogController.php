<?php

namespace App\Http\Controllers;

use App\Models\FlightLog;
use Illuminate\Http\Request;

class FlightLogController extends Controller
{
    public function index()
    {
        return FlightLog::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'user' => 'required|string|max:100',
            'flightno' => 'required|string|max:8',
            'from_old' => 'required|integer',
            'to_old' => 'required|integer',
            'from_new' => 'required|integer',
            'to_new' => 'required|integer',
            'departure_old' => 'required|date',
            'arrival_old' => 'required|date',
            'departure_new' => 'required|date',
            'arrival_new' => 'required|date',
            'airplane_id_old' => 'required|integer',
            'airplane_id_new' => 'required|integer',
            'airline_id_old' => 'required|integer',
            'airline_id_new' => 'required|integer',
            'comment' => 'nullable|string|max:200',
        ]);

        return FlightLog::create($validated);
    }

    public function show($id)
    {
        return FlightLog::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $log = FlightLog::findOrFail($id);
        $log->update($request->all());
        return $log;
    }

    public function destroy($id)
    {
        FlightLog::destroy($id);
        return response()->noContent();
    }
}
