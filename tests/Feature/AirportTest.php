<?php

namespace Tests\Feature;

use App\Models\Airport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AirportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_airports(): void
    {
        Airport::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/airports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'iata_code',
                        'city',
                        'country',
                        'latitude',
                        'longitude',
                    ],
                ],
                'meta' => ['total'],
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_can_show_specific_airport(): void
    {
        $airport = Airport::factory()->create([
            'name' => 'Test Airport',
            'iata_code' => 'TST',
        ]);

        $response = $this->getJson("/api/v1/airports/{$airport->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $airport->id,
                    'name' => 'Test Airport',
                    'iata_code' => 'TST',
                ],
            ]);
    }

    public function test_returns_404_for_non_existent_airport(): void
    {
        $response = $this->getJson('/api/v1/airports/99999');

        $response->assertStatus(404);
    }
}
