<?php

namespace App\Http\Controllers;

use App\Models\AirportGeo;
use Illuminate\Http\Request;

class AirportGeoController extends Controller
{
    public function index()
    {
        return AirportGeo::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'country' => 'required|string|max:50',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'geolocation' => 'nullable',
        ]);

        return AirportGeo::create($validated);
    }

    public function show($id)
    {
        return AirportGeo::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $geo = AirportGeo::findOrFail($id);
        $geo->update($request->all());
        return $geo;
    }

    public function destroy($id)
    {
        AirportGeo::destroy($id);
        return response()->noContent();
    }
}
