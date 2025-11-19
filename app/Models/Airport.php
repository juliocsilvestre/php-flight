<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iata_code',
        'city',
        'country',
        'latitude',
        'longitude',
        'timezone',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function departureFlights()
    {
        return $this->hasMany(Flight::class, 'departure_airport_id');
    }

    public function arrivalFlights()
    {
        return $this->hasMany(Flight::class, 'arrival_airport_id');
    }

    public function getCoordinatesAttribute(): array
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];
    }
}
