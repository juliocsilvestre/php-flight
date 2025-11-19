<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        $departureTime = fake()->dateTimeBetween('now', '+30 days');
        $arrivalTime = Carbon::instance($departureTime)->addHours(fake()->numberBetween(1, 12));

        return [
            'departure_airport_id' => Airport::factory(),
            'arrival_airport_id' => Airport::factory(),
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'weather_data' => [
                'temperature' => fake()->numberBetween(-10, 40),
                'condition' => fake()->randomElement(['Clear', 'Cloudy', 'Rainy', 'Stormy']),
                'humidity' => fake()->numberBetween(30, 90),
                'wind_speed' => fake()->numberBetween(0, 50),
            ],
            'season_type' => fake()->randomElement(['high', 'low']),
            'traffic_level' => fake()->randomElement(['high', 'medium', 'low']),
            'render_3d_url' => null,
        ];
    }
}
