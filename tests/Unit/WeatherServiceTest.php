<?php

namespace Tests\Unit;

use App\Services\WeatherService;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    public function test_returns_weather_data(): void
    {
        $service = new WeatherService();
        
        $weather = $service->getWeatherByCoordinates(-23.5505, -46.6333);

        $this->assertIsArray($weather);
        $this->assertArrayHasKey('temperature', $weather);
        $this->assertArrayHasKey('condition', $weather);
        $this->assertArrayHasKey('humidity', $weather);
        $this->assertArrayHasKey('wind_speed', $weather);
    }

    public function test_weather_data_has_valid_ranges(): void
    {
        $service = new WeatherService();
        
        $weather = $service->getWeatherByCoordinates(40.7128, -74.0060);

        $this->assertGreaterThanOrEqual(-50, $weather['temperature']);
        $this->assertLessThanOrEqual(60, $weather['temperature']);
        $this->assertGreaterThanOrEqual(0, $weather['humidity']);
        $this->assertLessThanOrEqual(100, $weather['humidity']);
    }
}
