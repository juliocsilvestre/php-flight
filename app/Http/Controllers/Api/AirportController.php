<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\JsonResponse;

class AirportController extends Controller
{
    public function index(): JsonResponse
    {
        $airports = Airport::select([
            'id',
            'name',
            'iata_code',
            'city',
            'country',
            'latitude',
            'longitude',
            'timezone',
        ])
        ->orderBy('name')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $airports,
            'meta' => [
                'total' => $airports->count(),
            ],
        ]);
    }

    public function show(Airport $airport): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $airport->id,
                'name' => $airport->name,
                'iata_code' => $airport->iata_code,
                'city' => $airport->city,
                'country' => $airport->country,
                'latitude' => $airport->latitude,
                'longitude' => $airport->longitude,
                'timezone' => $airport->timezone,
                'coordinates' => $airport->coordinates,
            ],
        ]);
    }
}
