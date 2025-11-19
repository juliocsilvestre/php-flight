<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlightRequest;
use App\Models\Flight;
use App\Models\Airport;
use App\Services\WeatherService;
use App\Services\SeasonService;
use App\Services\TrafficService;
use App\Services\Flight3DRenderService;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class FlightController extends Controller
{
    public function __construct(
        private WeatherService $weatherService,
        private SeasonService $seasonService,
        private TrafficService $trafficService,
        private Flight3DRenderService $renderService
    ) {}

    public function store(StoreFlightRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Get airports
        $departureAirport = Airport::findOrFail($validated['departure_airport_id']);
        $arrivalAirport = Airport::findOrFail($validated['arrival_airport_id']);

        // Parse times
        $departureTime = Carbon::parse($validated['departure_time']);
        $arrivalTime = Carbon::parse($validated['arrival_time']);

        // Get weather data for arrival airport
        $weatherData = $this->weatherService->getWeatherByCoordinates(
            $arrivalAirport->latitude,
            $arrivalAirport->longitude
        );

        // Determine season type
        $seasonInfo = $this->seasonService->getSeasonInfo($departureTime);

        // Determine traffic level
        $trafficInfo = $this->trafficService->getTrafficInfo($departureTime);

        // Generate 3D render
        $render3DUrl = $this->renderService->generate3DFlightPath(
            $departureAirport,
            $arrivalAirport
        );

        // Calculate distance
        $distance = $this->renderService->calculateDistance(
            $departureAirport->latitude,
            $departureAirport->longitude,
            $arrivalAirport->latitude,
            $arrivalAirport->longitude
        );

        // Create flight
        $flight = Flight::create([
            'departure_airport_id' => $departureAirport->id,
            'arrival_airport_id' => $arrivalAirport->id,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'weather_data' => $weatherData,
            'season_type' => $seasonInfo['type'],
            'traffic_level' => $trafficInfo['level'],
            'render_3d_url' => $render3DUrl,
        ]);

        // Load relationships
        $flight->load(['departureAirport', 'arrivalAirport']);

        return response()->json([
            'success' => true,
            'message' => 'Análise de voo gerada com sucesso',
            'data' => [
                'flight' => [
                    'id' => $flight->id,
                    'departure_time' => $flight->departure_time->toIso8601String(),
                    'arrival_time' => $flight->arrival_time->toIso8601String(),
                    'duration' => $flight->duration,
                    'formatted_duration' => $flight->formatted_duration,
                    'departure_airport' => [
                        'id' => $departureAirport->id,
                        'name' => $departureAirport->name,
                        'iata_code' => $departureAirport->iata_code,
                        'city' => $departureAirport->city,
                        'country' => $departureAirport->country,
                        'coordinates' => $departureAirport->coordinates,
                    ],
                    'arrival_airport' => [
                        'id' => $arrivalAirport->id,
                        'name' => $arrivalAirport->name,
                        'iata_code' => $arrivalAirport->iata_code,
                        'city' => $arrivalAirport->city,
                        'country' => $arrivalAirport->country,
                        'coordinates' => $arrivalAirport->coordinates,
                    ],
                    'distance_km' => $distance,
                ],
                'weather' => $weatherData,
                'season' => $seasonInfo,
                'traffic' => $trafficInfo,
                'visualization' => [
                    'render_3d_url' => $render3DUrl,
                    'enabled' => $this->renderService->isEnabled(),
                ],
            ],
        ], 201);
    }

    public function show(Flight $flight): JsonResponse
    {
        $flight->load(['departureAirport', 'arrivalAirport']);

        // Recalculate season and traffic info
        $seasonInfo = $this->seasonService->getSeasonInfo($flight->departure_time);
        $trafficInfo = $this->trafficService->getTrafficInfo($flight->departure_time);

        // Calculate distance
        $distance = $this->renderService->calculateDistance(
            $flight->departureAirport->latitude,
            $flight->departureAirport->longitude,
            $flight->arrivalAirport->latitude,
            $flight->arrivalAirport->longitude
        );

        return response()->json([
            'success' => true,
            'data' => [
                'flight' => [
                    'id' => $flight->id,
                    'departure_time' => $flight->departure_time->toIso8601String(),
                    'arrival_time' => $flight->arrival_time->toIso8601String(),
                    'duration' => $flight->duration,
                    'formatted_duration' => $flight->formatted_duration,
                    'departure_airport' => [
                        'id' => $flight->departureAirport->id,
                        'name' => $flight->departureAirport->name,
                        'iata_code' => $flight->departureAirport->iata_code,
                        'city' => $flight->departureAirport->city,
                        'country' => $flight->departureAirport->country,
                        'coordinates' => $flight->departureAirport->coordinates,
                    ],
                    'arrival_airport' => [
                        'id' => $flight->arrivalAirport->id,
                        'name' => $flight->arrivalAirport->name,
                        'iata_code' => $flight->arrivalAirport->iata_code,
                        'city' => $flight->arrivalAirport->city,
                        'country' => $flight->arrivalAirport->country,
                        'coordinates' => $flight->arrivalAirport->coordinates,
                    ],
                    'distance_km' => $distance,
                ],
                'weather' => $flight->weather_data,
                'season' => $seasonInfo,
                'traffic' => $trafficInfo,
                'visualization' => [
                    'render_3d_url' => $flight->render_3d_url,
                    'enabled' => $this->renderService->isEnabled(),
                ],
            ],
        ]);
    }
}
