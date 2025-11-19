<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private string $apiKey;
    private string $apiUrl;
    private bool $useMock;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key', '');
        $this->apiUrl = config('services.openweather.api_url', 'https://api.openweathermap.org/data/2.5');
        $this->useMock = empty($this->apiKey) || $this->apiKey === 'your_api_key_here';
    }

    public function getWeatherByCoordinates(float $latitude, float $longitude): array
    {
        if ($this->useMock) {
            return $this->getMockWeather();
        }

        try {
            $response = Http::get("{$this->apiUrl}/weather", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'pt_br',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->formatWeatherData($data);
            }

            Log::warning('Weather API failed, using mock data', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->getMockWeather();
        } catch (\Exception $e) {
            Log::error('Weather API error: ' . $e->getMessage());
            return $this->getMockWeather();
        }
    }

    private function formatWeatherData(array $data): array
    {
        return [
            'temperature' => round($data['main']['temp'], 1),
            'feels_like' => round($data['main']['feels_like'], 1),
            'condition' => $data['weather'][0]['main'] ?? 'Clear',
            'description' => $data['weather'][0]['description'] ?? 'Céu limpo',
            'humidity' => $data['main']['humidity'],
            'pressure' => $data['main']['pressure'],
            'wind_speed' => round($data['wind']['speed'] * 3.6, 1), // m/s to km/h
            'wind_direction' => $data['wind']['deg'] ?? 0,
            'clouds' => $data['clouds']['all'] ?? 0,
            'visibility' => isset($data['visibility']) ? round($data['visibility'] / 1000, 1) : 10,
            'icon' => $data['weather'][0]['icon'] ?? '01d',
        ];
    }

    private function getMockWeather(): array
    {
        $conditions = [
            ['condition' => 'Clear', 'description' => 'Céu limpo', 'icon' => '01d'],
            ['condition' => 'Clouds', 'description' => 'Parcialmente nublado', 'icon' => '02d'],
            ['condition' => 'Rain', 'description' => 'Chuva leve', 'icon' => '10d'],
            ['condition' => 'Drizzle', 'description' => 'Garoa', 'icon' => '09d'],
        ];

        $selected = $conditions[array_rand($conditions)];

        return [
            'temperature' => rand(15, 32),
            'feels_like' => rand(15, 32),
            'condition' => $selected['condition'],
            'description' => $selected['description'],
            'humidity' => rand(40, 85),
            'pressure' => rand(1000, 1025),
            'wind_speed' => rand(5, 35),
            'wind_direction' => rand(0, 360),
            'clouds' => rand(0, 100),
            'visibility' => rand(5, 10),
            'icon' => $selected['icon'],
        ];
    }

    public function getWeatherForecast(float $latitude, float $longitude, int $days = 5): array
    {
        if ($this->useMock) {
            return $this->getMockForecast($days);
        }

        try {
            $response = Http::get("{$this->apiUrl}/forecast", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'pt_br',
                'cnt' => $days * 8, // 3-hour intervals
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return $this->getMockForecast($days);
        } catch (\Exception $e) {
            Log::error('Weather forecast API error: ' . $e->getMessage());
            return $this->getMockForecast($days);
        }
    }

    private function getMockForecast(int $days): array
    {
        $forecast = [];
        for ($i = 0; $i < $days; $i++) {
            $forecast[] = $this->getMockWeather();
        }
        return ['list' => $forecast];
    }
}
