<?php

namespace App\Http\Controllers;

use App\Models\PassengerDetails;
use Illuminate\Http\Request;

class PassengerDetailsController extends Controller
{
    public function index()
    {
        return PassengerDetails::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passenger_id' => 'required|integer|unique:passengerdetails,passenger_id',
            'birthdate' => 'required|date',
            'sex' => 'required|string|max:1',
            'street' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'required|integer',
            'country' => 'required|string|max:120',
            'emailaddress' => 'required|email|max:120',
            'telephone' => 'required|string|max:30',
        ]);

        return PassengerDetails::create($validated);
    }

    public function show($id)
    {
        return PassengerDetails::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $details = PassengerDetails::findOrFail($id);
        $details->update($request->all());
        return $details;
    }

    public function destroy($id)
    {
        PassengerDetails::destroy($id);
        return response()->noContent();
    }
}
