<?php

namespace App\Http\Controllers;

use App\Models\AirportReachable;
use Illuminate\Http\Request;

class AirportReachableController extends Controller
{
    public function index()
    {
        return AirportReachable::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'airport_id' => 'required|integer',
            'hops' => 'required|integer',
        ]);

        return AirportReachable::create($validated);
    }

    public function show($id)
    {
        return AirportReachable::where('airport_id', $id)->firstOrFail();
    }

    public function update(Request $request, $id)
    {
        $reachable = AirportReachable::where('airport_id', $id)->firstOrFail();
        $reachable->update($request->all());
        return $reachable;
    }

    public function destroy($id)
    {
        AirportReachable::where('airport_id', $id)->delete();
        return response()->noContent();
    }
}
