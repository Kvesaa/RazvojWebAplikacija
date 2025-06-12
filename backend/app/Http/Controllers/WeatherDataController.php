<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use Illuminate\Http\Request;

class WeatherDataController extends Controller
{
    public function index()
    {
        return WeatherData::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'station' => 'required|string|max:11',
            'temp' => 'required|numeric',
            'humidity' => 'required|numeric',
            'airpressure' => 'required|numeric',
            'windspeed' => 'required|numeric',
            'weather' => 'required|in:sunny,rain,snow,fog,storm',
            'winddirection' => 'required|integer',
        ]);

        return WeatherData::create($validated);
    }

    public function show($id)
    {
        return WeatherData::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $weather = WeatherData::findOrFail($id);
        $weather->update($request->all());
        return $weather;
    }

    public function destroy($id)
    {
        WeatherData::destroy($id);
        return response()->noContent();
    }
}
