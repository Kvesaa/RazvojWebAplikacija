<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

/**
 * @group Flight Management
 * 
 * APIs for managing flight schedules and information.
 */
class FlightController extends Controller
{
    /**
     * List all flights
     * 
     * Get a list of all flights in the system.
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "flightno": "AA100",
     *       "from": 1,
     *       "to": 2,
     *       "departure": "2023-01-01T10:00:00.000000Z",
     *       "arrival": "2023-01-01T14:00:00.000000Z",
     *       "airline_id": 1,
     *       "airplane_id": 1,
     *       "created_at": "2023-01-01T00:00:00.000000Z",
     *       "updated_at": "2023-01-01T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return Flight::all();
    }

    /**
     * Create a new flight
     * 
     * Create a new flight with the provided information.
     * 
     * @bodyParam flightno string required The flight number. Example: AA100
     * @bodyParam from integer required The departure airport ID. Example: 1
     * @bodyParam to integer required The arrival airport ID. Example: 2
     * @bodyParam departure string required The departure date and time. Example: 2023-01-01 10:00:00
     * @bodyParam arrival string required The arrival date and time. Example: 2023-01-01 14:00:00
     * @bodyParam airline_id integer required The airline ID. Example: 1
     * @bodyParam airplane_id integer required The airplane ID. Example: 1
     * 
     * @response 201 {
     *   "id": 1,
     *   "flightno": "AA100",
     *   "from": 1,
     *   "to": 2,
     *   "departure": "2023-01-01T10:00:00.000000Z",
     *   "arrival": "2023-01-01T14:00:00.000000Z",
     *   "airline_id": 1,
     *   "airplane_id": 1,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "flightno": ["The flightno field is required."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flightno' => 'required|string|max:8',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'departure' => 'required|date',
            'arrival' => 'required|date',
            'airline_id' => 'required|integer',
            'airplane_id' => 'required|integer',
        ]);

        return Flight::create($validated);
    }

    /**
     * Show a specific flight
     * 
     * Get details of a specific flight by ID.
     * 
     * @urlParam id integer required The ID of the flight. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "flightno": "AA100",
     *   "from": 1,
     *   "to": 2,
     *   "departure": "2023-01-01T10:00:00.000000Z",
     *   "arrival": "2023-01-01T14:00:00.000000Z",
     *   "airline_id": 1,
     *   "airplane_id": 1,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Flight] 1"
     * }
     */
    public function show($id)
    {
        return Flight::findOrFail($id);
    }

    /**
     * Update a flight
     * 
     * Update an existing flight's information.
     * 
     * @urlParam id integer required The ID of the flight. Example: 1
     * @bodyParam flightno string The flight number. Example: AA100
     * @bodyParam from integer The departure airport ID. Example: 1
     * @bodyParam to integer The arrival airport ID. Example: 2
     * @bodyParam departure string The departure date and time. Example: 2023-01-01 10:00:00
     * @bodyParam arrival string The arrival date and time. Example: 2023-01-01 14:00:00
     * @bodyParam airline_id integer The airline ID. Example: 1
     * @bodyParam airplane_id integer The airplane ID. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "flightno": "AA100",
     *   "from": 1,
     *   "to": 2,
     *   "departure": "2023-01-01T10:00:00.000000Z",
     *   "arrival": "2023-01-01T14:00:00.000000Z",
     *   "airline_id": 1,
     *   "airplane_id": 1,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Flight] 1"
     * }
     */
    public function update(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $flight->update($request->all());
        return $flight;
    }

    /**
     * Delete a flight
     * 
     * Remove a flight from the system.
     * 
     * @urlParam id integer required The ID of the flight. Example: 1
     * 
     * @response 204
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Flight] 1"
     * }
     */
    public function destroy($id)
    {
        Flight::destroy($id);
        return response()->noContent();
    }
}
