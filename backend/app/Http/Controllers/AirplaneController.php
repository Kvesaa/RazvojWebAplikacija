<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use Illuminate\Http\Request;

class AirplaneController extends Controller
{
    public function index()
    {
        return Airplane::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'capacity' => 'required|integer',
            'type_id' => 'required|integer',
            'airline_id' => 'required|integer',
        ]);

        return Airplane::create($validated);
    }

    public function show($id)
    {
        return Airplane::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $airplane = Airplane::findOrFail($id);
        $airplane->update($request->all());
        return $airplane;
    }

    public function destroy($id)
    {
        Airplane::destroy($id);
        return response()->noContent();
    }
}
