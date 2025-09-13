<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AirportGeoController;
use App\Http\Controllers\AirportReachableController;
use App\Http\Controllers\AirplaneController;
use App\Http\Controllers\AirplaneTypeController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\FlightScheduleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\PassengerDetailsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightLogController;
use App\Http\Controllers\WeatherDataController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Token management routes
Route::post('/token', [AuthController::class, 'issueToken']);
Route::delete('/token', [AuthController::class, 'revokeToken'])->middleware('auth:sanctum');

// API Version 1 - HTTP Basic Auth
Route::prefix('v1')->group(function () {
    // Public read access for airport and airline
    Route::get('airport', [AirportController::class, 'index']);
    Route::get('airport/{id}', [AirportController::class, 'show']);
    Route::get('airline', [AirlineController::class, 'index']);
    Route::get('airline/{id}', [AirlineController::class, 'show']);
    
    // Protected write operations for airport and airline
    Route::middleware(['auth.basic', 'rolematrix'])->group(function () {
        Route::post('airport', [AirportController::class, 'store']);
        Route::put('airport/{id}', [AirportController::class, 'update']);
        Route::delete('airport/{id}', [AirportController::class, 'destroy']);
        
        Route::post('airline', [AirlineController::class, 'store']);
        Route::put('airline/{id}', [AirlineController::class, 'update']);
        Route::delete('airline/{id}', [AirlineController::class, 'destroy']);
    });
    
    // All other resources require Basic Auth + Role-based permissions
    Route::middleware(['auth.basic', 'rolematrix'])->group(function () {
        // Flight routes with role-based permissions
        Route::get('flights', [FlightController::class, 'index']);
        Route::post('flights', [FlightController::class, 'store']);
        Route::get('flights/{id}', [FlightController::class, 'show']);
        Route::put('flights/{id}', [FlightController::class, 'update']);
        Route::delete('flights/{id}', [FlightController::class, 'destroy']);
        
        // Other resources with basic CRUD permissions
        Route::apiResource('airport-geo', AirportGeoController::class);
        Route::apiResource('airport-reachable', AirportReachableController::class);
        Route::apiResource('airplane', AirplaneController::class);
        Route::apiResource('airplane-types', AirplaneTypeController::class);
        Route::apiResource('flight-schedules', FlightScheduleController::class);
        Route::apiResource('employee', EmployeeController::class);
        Route::apiResource('passengers', PassengerController::class);
        Route::apiResource('passenger-details', PassengerDetailsController::class);
        Route::apiResource('booking', BookingController::class);
        Route::apiResource('flight-log', FlightLogController::class);
        Route::apiResource('weather-data', WeatherDataController::class);
    });
});

// API Version 2 - Sanctum + Role-based permissions
Route::prefix('v2')->middleware(['auth:sanctum', 'rolematrix'])->group(function () {
    // Airport routes with role-based permissions
    Route::get('airport', [AirportController::class, 'index']);
    Route::post('airport', [AirportController::class, 'store']);
    Route::get('airport/{id}', [AirportController::class, 'show']);
    Route::put('airport/{id}', [AirportController::class, 'update']);
    Route::delete('airport/{id}', [AirportController::class, 'destroy']);
    
    // Airline routes with role-based permissions
    Route::get('airline', [AirlineController::class, 'index']);
    Route::post('airline', [AirlineController::class, 'store']);
    Route::get('airline/{id}', [AirlineController::class, 'show']);
    Route::put('airline/{id}', [AirlineController::class, 'update']);
    Route::delete('airline/{id}', [AirlineController::class, 'destroy']);
    
    // Flight routes with role-based permissions
    Route::get('flights', [FlightController::class, 'index']);
    Route::post('flights', [FlightController::class, 'store']);
    Route::get('flights/{id}', [FlightController::class, 'show']);
    Route::put('flights/{id}', [FlightController::class, 'update']);
    Route::delete('flights/{id}', [FlightController::class, 'destroy']);
    
    // Other resources with basic CRUD permissions
    Route::apiResource('airport-geo', AirportGeoController::class);
    Route::apiResource('airport-reachable', AirportReachableController::class);
    Route::apiResource('airplane', AirplaneController::class);
    Route::apiResource('airplane-types', AirplaneTypeController::class);
    Route::apiResource('flight-schedules', FlightScheduleController::class);
    Route::apiResource('employee', EmployeeController::class);
    Route::apiResource('passengers', PassengerController::class);
    Route::apiResource('passenger-details', PassengerDetailsController::class);
    Route::apiResource('booking', BookingController::class);
    Route::apiResource('flight-log', FlightLogController::class);
    Route::apiResource('weather-data', WeatherDataController::class);
});
