<?php

namespace Tests\Unit;

use App\Services\Flight3DRenderService;
use App\Models\Airport;
use Tests\TestCase;

class Flight3DRenderServiceTest extends TestCase
{
    public function test_generates_3d_render(): void
    {
        $service = new Flight3DRenderService();
        
        $departure = new Airport([
            'iata_code' => 'GRU',
            'latitude' => -23.432075,
            'longitude' => -46.469511,
        ]);
        
        $arrival = new Airport([
            'iata_code' => 'JFK',
            'latitude' => 40.639751,
            'longitude' => -73.778925,
        ]);

        $render = $service->generate3DFlightPath($departure, $arrival);

        $this->assertIsString($render);
        $this->assertStringStartsWith('data:image/svg+xml;base64,', $render);
    }

    public function test_calculates_distance_between_airports(): void
    {
        $service = new Flight3DRenderService();
        
        // GRU to JFK approximate distance
        $distance = $service->calculateDistance(
            -23.432075,
            -46.469511,
            40.639751,
            -73.778925
        );

        $this->assertIsFloat($distance);
        $this->assertGreaterThan(7500, $distance); // Approximately 7800 km
        $this->assertLessThan(8500, $distance);
    }
}
