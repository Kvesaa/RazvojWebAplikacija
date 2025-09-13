<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

/**
 * @group Airline Management
 * 
 * APIs for managing airline companies and their information.
 */
class AirlineController extends Controller
{
    /**
     * List all airlines
     * 
     * Get a list of all airlines in the system.
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "iata": "AA",
     *       "airlinename": "American Airlines",
     *       "base_airport": 1,
     *       "created_at": "2023-01-01T00:00:00.000000Z",
     *       "updated_at": "2023-01-01T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return Airline::all();
    }

    /**
     * Create a new airline
     * 
     * Create a new airline with the provided information.
     * 
     * @bodyParam iata string required The IATA code (2 characters). Example: AA
     * @bodyParam airlinename string required The airline name. Example: American Airlines
     * @bodyParam base_airport integer required The ID of the base airport. Example: 1
     * 
     * @response 201 {
     *   "id": 1,
     *   "iata": "AA",
     *   "airlinename": "American Airlines",
     *   "base_airport": 1,
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
            'iata' => 'required|string|max:2',
            'airlinename' => 'required|string|max:30',
            'base_airport' => 'required|integer',
        ]);

        return Airline::create($validated);
    }

    /**
     * Show a specific airline
     * 
     * Get details of a specific airline by ID.
     * 
     * @urlParam id integer required The ID of the airline. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "iata": "AA",
     *   "airlinename": "American Airlines",
     *   "base_airport": 1,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airline] 1"
     * }
     */
    public function show($id)
    {
        return Airline::findOrFail($id);
    }

    /**
     * Update an airline
     * 
     * Update an existing airline's information.
     * 
     * @urlParam id integer required The ID of the airline. Example: 1
     * @bodyParam iata string The IATA code (2 characters). Example: AA
     * @bodyParam airlinename string The airline name. Example: American Airlines
     * @bodyParam base_airport integer The ID of the base airport. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "iata": "AA",
     *   "airlinename": "American Airlines",
     *   "base_airport": 1,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z"
     * }
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airline] 1"
     * }
     */
    public function update(Request $request, $id)
    {
        $airline = Airline::findOrFail($id);
        $airline->update($request->all());
        return $airline;
    }

    /**
     * Delete an airline
     * 
     * Remove an airline from the system.
     * 
     * @urlParam id integer required The ID of the airline. Example: 1
     * 
     * @response 204
     * 
     * @response 404 {
     *   "message": "No query results for model [App\\Models\\Airline] 1"
     * }
     */
    public function destroy($id)
    {
        Airline::destroy($id);
        return response()->noContent();
    }
}
