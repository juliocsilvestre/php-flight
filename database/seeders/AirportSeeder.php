<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            [
                'name' => 'Aeroporto Internacional de Guarulhos',
                'iata_code' => 'GRU',
                'city' => 'São Paulo',
                'country' => 'Brasil',
                'latitude' => -23.432075,
                'longitude' => -46.469511,
                'timezone' => 'America/Sao_Paulo',
            ],
            [
                'name' => 'Aeroporto Santos Dumont',
                'iata_code' => 'SDU',
                'city' => 'Rio de Janeiro',
                'country' => 'Brasil',
                'latitude' => -22.910461,
                'longitude' => -43.163133,
                'timezone' => 'America/Sao_Paulo',
            ],
            [
                'name' => 'Aeroporto Internacional de Brasília',
                'iata_code' => 'BSB',
                'city' => 'Brasília',
                'country' => 'Brasil',
                'latitude' => -15.869167,
                'longitude' => -47.920833,
                'timezone' => 'America/Sao_Paulo',
            ],
            [
                'name' => 'Aeroporto de Congonhas',
                'iata_code' => 'CGH',
                'city' => 'São Paulo',
                'country' => 'Brasil',
                'latitude' => -23.626667,
                'longitude' => -46.655833,
                'timezone' => 'America/Sao_Paulo',
            ],
            [
                'name' => 'Aeroporto Internacional de Confins',
                'iata_code' => 'CNF',
                'city' => 'Belo Horizonte',
                'country' => 'Brasil',
                'latitude' => -19.624444,
                'longitude' => -43.971944,
                'timezone' => 'America/Sao_Paulo',
            ],
            [
                'name' => 'John F. Kennedy International Airport',
                'iata_code' => 'JFK',
                'city' => 'New York',
                'country' => 'United States',
                'latitude' => 40.639751,
                'longitude' => -73.778925,
                'timezone' => 'America/New_York',
            ],
            [
                'name' => 'Los Angeles International Airport',
                'iata_code' => 'LAX',
                'city' => 'Los Angeles',
                'country' => 'United States',
                'latitude' => 33.942536,
                'longitude' => -118.408075,
                'timezone' => 'America/Los_Angeles',
            ],
            [
                'name' => 'London Heathrow Airport',
                'iata_code' => 'LHR',
                'city' => 'London',
                'country' => 'United Kingdom',
                'latitude' => 51.470022,
                'longitude' => -0.454295,
                'timezone' => 'Europe/London',
            ],
            [
                'name' => 'Paris Charles de Gaulle Airport',
                'iata_code' => 'CDG',
                'city' => 'Paris',
                'country' => 'France',
                'latitude' => 49.012779,
                'longitude' => 2.550000,
                'timezone' => 'Europe/Paris',
            ],
            [
                'name' => 'Dubai International Airport',
                'iata_code' => 'DXB',
                'city' => 'Dubai',
                'country' => 'United Arab Emirates',
                'latitude' => 25.252778,
                'longitude' => 55.364444,
                'timezone' => 'Asia/Dubai',
            ],
            [
                'name' => 'Tokyo Haneda Airport',
                'iata_code' => 'HND',
                'city' => 'Tokyo',
                'country' => 'Japan',
                'latitude' => 35.552258,
                'longitude' => 139.779694,
                'timezone' => 'Asia/Tokyo',
            ],
            [
                'name' => 'Singapore Changi Airport',
                'iata_code' => 'SIN',
                'city' => 'Singapore',
                'country' => 'Singapore',
                'latitude' => 1.350189,
                'longitude' => 103.994433,
                'timezone' => 'Asia/Singapore',
            ],
            [
                'name' => 'Sydney Kingsford Smith Airport',
                'iata_code' => 'SYD',
                'city' => 'Sydney',
                'country' => 'Australia',
                'latitude' => -33.946111,
                'longitude' => 151.177222,
                'timezone' => 'Australia/Sydney',
            ],
            [
                'name' => 'Frankfurt Airport',
                'iata_code' => 'FRA',
                'city' => 'Frankfurt',
                'country' => 'Germany',
                'latitude' => 50.026421,
                'longitude' => 8.543125,
                'timezone' => 'Europe/Berlin',
            ],
            [
                'name' => 'Amsterdam Airport Schiphol',
                'iata_code' => 'AMS',
                'city' => 'Amsterdam',
                'country' => 'Netherlands',
                'latitude' => 52.308601,
                'longitude' => 4.763889,
                'timezone' => 'Europe/Amsterdam',
            ],
            [
                'name' => 'Hong Kong International Airport',
                'iata_code' => 'HKG',
                'city' => 'Hong Kong',
                'country' => 'Hong Kong',
                'latitude' => 22.308919,
                'longitude' => 113.914603,
                'timezone' => 'Asia/Hong_Kong',
            ],
            [
                'name' => 'Barcelona–El Prat Airport',
                'iata_code' => 'BCN',
                'city' => 'Barcelona',
                'country' => 'Spain',
                'latitude' => 41.297078,
                'longitude' => 2.078464,
                'timezone' => 'Europe/Madrid',
            ],
            [
                'name' => 'Toronto Pearson International Airport',
                'iata_code' => 'YYZ',
                'city' => 'Toronto',
                'country' => 'Canada',
                'latitude' => 43.677223,
                'longitude' => -79.630556,
                'timezone' => 'America/Toronto',
            ],
            [
                'name' => 'Aeroporto Internacional de Lisboa',
                'iata_code' => 'LIS',
                'city' => 'Lisboa',
                'country' => 'Portugal',
                'latitude' => 38.781311,
                'longitude' => -9.135919,
                'timezone' => 'Europe/Lisbon',
            ],
            [
                'name' => 'Aeropuerto Internacional Benito Juárez',
                'iata_code' => 'MEX',
                'city' => 'Mexico City',
                'country' => 'Mexico',
                'latitude' => 19.436303,
                'longitude' => -99.072097,
                'timezone' => 'America/Mexico_City',
            ],
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}
