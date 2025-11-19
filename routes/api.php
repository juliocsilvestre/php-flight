<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\AirportController;

Route::prefix('v1')->group(function () {
    // Airports
    Route::get('/airports', [AirportController::class, 'index']);
    Route::get('/airports/{airport}', [AirportController::class, 'show']);
    
    // Flights
    Route::post('/flights', [FlightController::class, 'store']);
    Route::get('/flights/{flight}', [FlightController::class, 'show']);
});
