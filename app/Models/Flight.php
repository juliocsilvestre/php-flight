<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_airport_id',
        'arrival_airport_id',
        'departure_time',
        'arrival_time',
        'weather_data',
        'season_type',
        'traffic_level',
        'render_3d_url',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'weather_data' => 'array',
    ];

    public function departureAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    public function arrivalAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    public function getDurationAttribute(): int
    {
        return $this->departure_time->diffInMinutes($this->arrival_time);
    }

    public function getFormattedDurationAttribute(): string
    {
        $duration = $this->duration;
        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        
        return sprintf('%dh %dmin', $hours, $minutes);
    }

    public function isHighSeason(): bool
    {
        return $this->season_type === 'high';
    }

    public function isHighTraffic(): bool
    {
        return $this->traffic_level === 'high';
    }
}
