<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        return Airport::all();
    }

    public function show($id)
    {
        return Airport::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'iata' => 'required|string|max:3',
            'icao' => 'required|string|max:4',
            'name' => 'required|string|max:50',
        ]);

        return Airport::create($validated);
    }

    public function update(Request $request, $id)
    {
        $airport = Airport::findOrFail($id);
        $airport->update($request->all());
        return $airport;
    }

    public function destroy($id)
    {
        Airport::destroy($id);
        return response()->noContent();
    }
}
