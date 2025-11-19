<?php

namespace App\Services;

use App\Models\Airport;
use Illuminate\Support\Facades\Log;

class Flight3DRenderService
{
    private bool $enabled;

    public function __construct()
    {
        $this->enabled = config('services.flight.render_3d_enabled', true);
    }

    public function generate3DFlightPath(
        Airport $departureAirport,
        Airport $arrivalAirport
    ): string {
        if (!$this->enabled) {
            return $this->generatePlaceholder();
        }

        try {
            // Generate SVG-based 3D-like flight path
            $svg = $this->generateFlightPathSVG(
                $departureAirport->latitude,
                $departureAirport->longitude,
                $arrivalAirport->latitude,
                $arrivalAirport->longitude,
                $departureAirport->iata_code,
                $arrivalAirport->iata_code
            );

            // Convert to base64 data URI
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        } catch (\Exception $e) {
            Log::error('3D render generation error: ' . $e->getMessage());
            return $this->generatePlaceholder();
        }
    }

    private function generateFlightPathSVG(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2,
        string $code1,
        string $code2
    ): string {
        $width = 800;
        $height = 600;
        
        // Normalize coordinates to SVG space
        $x1 = $this->longitudeToX($lon1, $width);
        $y1 = $this->latitudeToY($lat1, $height);
        $x2 = $this->longitudeToX($lon2, $width);
        $y2 = $this->latitudeToY($lat2, $height);
        
        // Calculate control points for curved path
        $midX = ($x1 + $x2) / 2;
        $midY = ($y1 + $y2) / 2 - 100; // Arc upward
        
        // Pre-calculate grid positions
        $grid1Y = $height * 0.33;
        $grid2Y = $height * 0.66;
        $grid1X = $width * 0.33;
        $grid2X = $width * 0.66;
        $centerX = $width / 2;
        $textY1 = $y1 - 15;
        $textY2 = $y2 - 15;
        
        // Generate SVG
        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="skyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" style="stop-color:#1e3a8a;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:1" />
    </linearGradient>
    <filter id="glow">
      <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
      <feMerge>
        <feMergeNode in="coloredBlur"/>
        <feMergeNode in="SourceGraphic"/>
      </feMerge>
    </filter>
  </defs>
  
  <!-- Background -->
  <rect width="{$width}" height="{$height}" fill="url(#skyGradient)"/>
  
  <!-- Grid lines for 3D effect -->
  <g opacity="0.2" stroke="#ffffff" stroke-width="1">
    <line x1="0" y1="{$grid1Y}" x2="{$width}" y2="{$grid1Y}"/>
    <line x1="0" y1="{$grid2Y}" x2="{$width}" y2="{$grid2Y}"/>
    <line x1="{$grid1X}" y1="0" x2="{$grid1X}" y2="{$height}"/>
    <line x1="{$grid2X}" y1="0" x2="{$grid2X}" y2="{$height}"/>
  </g>
  
  <!-- Flight path -->
  <path d="M {$x1},{$y1} Q {$midX},{$midY} {$x2},{$y2}" 
        stroke="#fbbf24" 
        stroke-width="3" 
        fill="none" 
        stroke-dasharray="10,5"
        filter="url(#glow)"/>
  
  <!-- Departure point -->
  <circle cx="{$x1}" cy="{$y1}" r="8" fill="#ef4444" filter="url(#glow)"/>
  <text x="{$x1}" y="{$textY1}" 
        fill="#ffffff" 
        font-family="Arial, sans-serif" 
        font-size="16" 
        font-weight="bold" 
        text-anchor="middle">{$code1}</text>
  
  <!-- Arrival point -->
  <circle cx="{$x2}" cy="{$y2}" r="8" fill="#10b981" filter="url(#glow)"/>
  <text x="{$x2}" y="{$textY2}" 
        fill="#ffffff" 
        font-family="Arial, sans-serif" 
        font-size="16" 
        font-weight="bold" 
        text-anchor="middle">{$code2}</text>
  
  <!-- Airplane icon at midpoint -->
  <g transform="translate({$midX}, {$midY})">
    <path d="M 0,-5 L 5,0 L 0,15 L -5,0 Z" fill="#ffffff" filter="url(#glow)"/>
    <circle cx="0" cy="5" r="2" fill="#fbbf24"/>
  </g>
  
  <!-- Distance indicator -->
  <text x="{$centerX}" y="30" 
        fill="#ffffff" 
        font-family="Arial, sans-serif" 
        font-size="14" 
        text-anchor="middle" 
        opacity="0.8">Flight Path Visualization</text>
</svg>
SVG;

        return $svg;
    }

    private function longitudeToX(float $longitude, int $width): float
    {
        // Map longitude (-180 to 180) to width
        return (($longitude + 180) / 360) * ($width * 0.8) + ($width * 0.1);
    }

    private function latitudeToY(float $latitude, int $height): float
    {
        // Map latitude (-90 to 90) to height (inverted)
        return $height - ((($latitude + 90) / 180) * ($height * 0.8) + ($height * 0.1));
    }

    private function generatePlaceholder(): string
    {
        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="600" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="600" fill="#1e3a8a"/>
  <text x="400" y="300" fill="#ffffff" font-family="Arial" font-size="24" text-anchor="middle">
    3D Visualization Unavailable
  </text>
</svg>
SVG;
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        // Haversine formula for great-circle distance
        $earthRadius = 6371; // kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
