<?php

namespace Tests\Feature;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class FlightTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_flight_analysis(): void
    {
        $departure = Airport::factory()->create(['iata_code' => 'GRU']);
        $arrival = Airport::factory()->create(['iata_code' => 'JFK']);

        $departureTime = Carbon::now()->addDay()->toIso8601String();
        $arrivalTime = Carbon::now()->addDay()->addHours(10)->toIso8601String();

        $response = $this->postJson('/api/v1/flights', [
            'departure_airport_id' => $departure->id,
            'arrival_airport_id' => $arrival->id,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'flight' => [
                        'id',
                        'departure_airport',
                        'arrival_airport',
                        'departure_time',
                        'arrival_time',
                        'duration',
                        'formatted_duration',
                        'distance_km',
                    ],
                    'weather',
                    'season',
                    'traffic',
                    'visualization',
                ],
            ]);

        $this->assertDatabaseHas('flights', [
            'departure_airport_id' => $departure->id,
            'arrival_airport_id' => $arrival->id,
        ]);
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/flights', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'departure_airport_id',
                'arrival_airport_id',
                'departure_time',
                'arrival_time',
            ]);
    }

    public function test_validates_different_airports(): void
    {
        $airport = Airport::factory()->create();
        $departureTime = Carbon::now()->addDay()->toIso8601String();
        $arrivalTime = Carbon::now()->addDay()->addHours(2)->toIso8601String();

        $response = $this->postJson('/api/v1/flights', [
            'departure_airport_id' => $airport->id,
            'arrival_airport_id' => $airport->id,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['arrival_airport_id']);
    }

    public function test_validates_arrival_after_departure(): void
    {
        $departure = Airport::factory()->create();
        $arrival = Airport::factory()->create();
        
        $departureTime = Carbon::now()->addDay()->addHours(5)->toIso8601String();
        $arrivalTime = Carbon::now()->addDay()->toIso8601String();

        $response = $this->postJson('/api/v1/flights', [
            'departure_airport_id' => $departure->id,
            'arrival_airport_id' => $arrival->id,
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['arrival_time']);
    }

    public function test_can_retrieve_flight_details(): void
    {
        $departure = Airport::factory()->create();
        $arrival = Airport::factory()->create();
        
        $flight = Flight::factory()->create([
            'departure_airport_id' => $departure->id,
            'arrival_airport_id' => $arrival->id,
        ]);

        $response = $this->getJson("/api/v1/flights/{$flight->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'flight' => [
                        'id' => $flight->id,
                    ],
                ],
            ]);
    }
}
