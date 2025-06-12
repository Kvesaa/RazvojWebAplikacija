<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index()
    {
        return Passenger::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passportno' => 'required|string|max:9',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
        ]);

        return Passenger::create($validated);
    }

    public function show($id)
    {
        return Passenger::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $passenger = Passenger::findOrFail($id);
        $passenger->update($request->all());
        return $passenger;
    }

    public function destroy($id)
    {
        Passenger::destroy($id);
        return response()->noContent();
    }
}
