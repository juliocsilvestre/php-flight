<?php

namespace App\Services;

use Carbon\Carbon;

class SeasonService
{
    private array $highSeasonMonths;

    public function __construct()
    {
        $configMonths = config('services.flight.high_season_months', '6,7,8,12,1');
        $this->highSeasonMonths = array_map('intval', explode(',', $configMonths));
    }

    public function determineSeasonType(Carbon $date): string
    {
        $month = $date->month;
        return in_array($month, $this->highSeasonMonths) ? 'high' : 'low';
    }

    public function getSeasonInfo(Carbon $date): array
    {
        $seasonType = $this->determineSeasonType($date);
        
        return [
            'type' => $seasonType,
            'label' => $seasonType === 'high' ? 'Alta Estação' : 'Baixa Estação',
            'description' => $this->getSeasonDescription($seasonType, $date),
            'price_impact' => $seasonType === 'high' ? 'high' : 'low',
            'crowding_level' => $seasonType === 'high' ? 'high' : 'medium',
        ];
    }

    private function getSeasonDescription(string $seasonType, Carbon $date): string
    {
        if ($seasonType === 'high') {
            $month = $date->month;
            
            if (in_array($month, [12, 1])) {
                return 'Período de festas de fim de ano - alta demanda de viagens';
            }
            
            if (in_array($month, [6, 7, 8])) {
                return 'Período de férias escolares - alta demanda familiar';
            }
            
            return 'Alta temporada turística';
        }

        return 'Período com menor demanda e melhores preços';
    }

    public function isHighSeason(Carbon $date): bool
    {
        return $this->determineSeasonType($date) === 'high';
    }

    public function getNextSeasonChange(Carbon $fromDate): array
    {
        $currentSeason = $this->determineSeasonType($fromDate);
        $checkDate = $fromDate->copy();
        
        // Look up to 12 months ahead
        for ($i = 0; $i < 12; $i++) {
            $checkDate->addMonth();
            $newSeason = $this->determineSeasonType($checkDate);
            
            if ($newSeason !== $currentSeason) {
                return [
                    'date' => $checkDate->toDateString(),
                    'from_season' => $currentSeason,
                    'to_season' => $newSeason,
                    'months_until' => $i + 1,
                ];
            }
        }

        return [
            'date' => null,
            'from_season' => $currentSeason,
            'to_season' => $currentSeason,
            'months_until' => null,
        ];
    }

    public function getHighSeasonMonths(): array
    {
        return $this->highSeasonMonths;
    }
}
