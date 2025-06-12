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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('airport', AirportController::class);
Route::apiResource('airport-geo', AirportGeoController::class);
Route::apiResource('airport-reachable', AirportReachableController::class);
Route::apiResource('airplane', AirplaneController::class);
Route::apiResource('airplane-types', AirplaneTypeController::class);
Route::apiResource('airline', AirlineController::class);
Route::apiResource('flights', FlightController::class);
Route::apiResource('flight-schedules', FlightScheduleController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('passengers', PassengerController::class);
Route::apiResource('passenger-details', PassengerDetailsController::class);
Route::apiResource('booking', BookingController::class);
Route::apiResource('flight-log', FlightLogController::class);
Route::apiResource('weather-data', WeatherDataController::class);
