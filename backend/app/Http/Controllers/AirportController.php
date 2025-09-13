<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

/**
 * @group Airport Management
 * 
 * APIs for managing airport information including IATA/ICAO codes and names.
 */
class AirportController extends Controller
{
    /**
     * List all airports
     * 
     * Get a list of all airports in the system.
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "iata": "LAX",
     *       "icao": "KLAX",
     *       "name": "Los Angeles International Airport",
     *       "created_at": "2023-01-01T00:00:00.000000Z",
     *       "updated_at": "2023-01-01T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return Airport::all();
    }

    /**
     * Show a specific airport
     * 
     * Get details of a specific airport by ID.
     * 
     * @urlParam id integer required The ID of the airport. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "iata": "LAX",
     *   "icao": "KLAX",
     *   "name": "Los Angeles International Airport",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airport] 1"
     * }
     */
    public function show($id)
    {
        return Airport::findOrFail($id);
    }

    /**
     * Create a new airport
     * 
     * Create a new airport with the provided information.
     * 
     * @bodyParam iata string required The IATA code (3 characters). Example: LAX
     * @bodyParam icao string required The ICAO code (4 characters). Example: KLAX
     * @bodyParam name string required The airport name. Example: Los Angeles International Airport
     * 
     * @response 201 {
     *   "id": 1,
     *   "iata": "LAX",
     *   "icao": "KLAX",
     *   "name": "Los Angeles International Airport",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "iata": ["The iata field is required."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'iata' => 'required|string|max:3',
            'icao' => 'required|string|max:4',
            'name' => 'required|string|max:50',
        ]);

        return Airport::create($validated);
    }

    /**
     * Update an airport
     * 
     * Update an existing airport's information.
     * 
     * @urlParam id integer required The ID of the airport. Example: 1
     * @bodyParam iata string The IATA code (3 characters). Example: LAX
     * @bodyParam icao string The ICAO code (4 characters). Example: KLAX
     * @bodyParam name string The airport name. Example: Los Angeles International Airport
     * 
     * @response 200 {
     *   "id": 1,
     *   "iata": "LAX",
     *   "icao": "KLAX",
     *   "name": "Los Angeles International Airport",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airport] 1"
     * }
     */
    public function update(Request $request, $id)
    {
        $airport = Airport::findOrFail($id);
        $airport->update($request->all());
        return $airport;
    }

    /**
     * Delete an airport
     * 
     * Remove an airport from the system.
     * 
     * @urlParam id integer required The ID of the airport. Example: 1
     * 
     * @response 204
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airport] 1"
     * }
     */
    public function destroy($id)
    {
        Airport::destroy($id);
        return response()->noContent();
    }
}
