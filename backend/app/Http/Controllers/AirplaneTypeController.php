<?php

namespace App\Http\Controllers;

use App\Models\AirplaneType;
use Illuminate\Http\Request;

class AirplaneTypeController extends Controller
{
    public function index()
    {
        return AirplaneType::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|string|max:8',
            'description' => 'required|string',
        ]);

        return AirplaneType::create($validated);
    }

    public function show($id)
    {
        return AirplaneType::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $type = AirplaneType::findOrFail($id);
        $type->update($request->all());
        return $type;
    }

    public function destroy($id)
    {
        AirplaneType::destroy($id);
        return response()->noContent();
    }
}
