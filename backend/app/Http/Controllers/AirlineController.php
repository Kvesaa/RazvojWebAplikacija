<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        return Airline::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'iata' => 'required|string|max:2',
            'airlinename' => 'required|string|max:30',
            'base_airport' => 'required|integer',
        ]);

        return Airline::create($validated);
    }

    public function show($id)
    {
        return Airline::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $airline = Airline::findOrFail($id);
        $airline->update($request->all());
        return $airline;
    }

    public function destroy($id)
    {
        Airline::destroy($id);
        return response()->noContent();
    }
}
