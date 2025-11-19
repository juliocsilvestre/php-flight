<?php

namespace App\Services;

use Carbon\Carbon;

class TrafficService
{
    private array $peakHours;
    private array $weekendDays;

    public function __construct()
    {
        $configHours = config('services.flight.peak_hours', '6,7,8,17,18,19,20');
        $this->peakHours = array_map('intval', explode(',', $configHours));
        $this->weekendDays = [Carbon::SATURDAY, Carbon::SUNDAY];
    }

    public function determineTrafficLevel(Carbon $datetime): string
    {
        $hour = $datetime->hour;
        $dayOfWeek = $datetime->dayOfWeek;
        
        $isPeakHour = in_array($hour, $this->peakHours);
        $isWeekend = in_array($dayOfWeek, $this->weekendDays);
        $isFriday = $dayOfWeek === Carbon::FRIDAY;
        
        // High traffic: peak hours on weekdays or Friday evenings
        if ($isPeakHour && !$isWeekend) {
            return 'high';
        }
        
        // High traffic: Friday evenings
        if ($isFriday && $hour >= 17) {
            return 'high';
        }
        
        // Medium traffic: weekend peak hours or weekday non-peak hours
        if ($isPeakHour && $isWeekend) {
            return 'medium';
        }
        
        if (!$isPeakHour && !$isWeekend && $hour >= 9 && $hour <= 21) {
            return 'medium';
        }
        
        // Low traffic: late night, early morning
        return 'low';
    }

    public function getTrafficInfo(Carbon $datetime): array
    {
        $level = $this->determineTrafficLevel($datetime);
        
        return [
            'level' => $level,
            'label' => $this->getTrafficLabel($level),
            'description' => $this->getTrafficDescription($level, $datetime),
            'wait_time_estimate' => $this->estimateWaitTime($level),
            'recommendation' => $this->getTrafficRecommendation($level),
        ];
    }

    private function getTrafficLabel(string $level): string
    {
        return match($level) {
            'high' => 'Tráfego Alto',
            'medium' => 'Tráfego Moderado',
            'low' => 'Tráfego Baixo',
            default => 'Tráfego Desconhecido',
        };
    }

    private function getTrafficDescription(string $level, Carbon $datetime): string
    {
        $hour = $datetime->hour;
        $isWeekend = in_array($datetime->dayOfWeek, $this->weekendDays);
        
        if ($level === 'high') {
            if ($isWeekend) {
                return 'Alto movimento no aeroporto durante fim de semana';
            }
            if ($hour >= 6 && $hour <= 9) {
                return 'Horário de pico matinal - muitos voos de negócios';
            }
            if ($hour >= 17 && $hour <= 20) {
                return 'Horário de pico vespertino - retorno de viajantes';
            }
            return 'Período de alto movimento no aeroporto';
        }
        
        if ($level === 'medium') {
            return 'Movimento moderado no aeroporto';
        }
        
        return 'Baixo movimento no aeroporto - ideal para embarque tranquilo';
    }

    private function estimateWaitTime(string $level): string
    {
        return match($level) {
            'high' => '45-90 min',
            'medium' => '20-45 min',
            'low' => '10-20 min',
            default => 'Não disponível',
        };
    }

    private function getTrafficRecommendation(string $level): string
    {
        return match($level) {
            'high' => 'Chegue ao aeroporto com 3 horas de antecedência',
            'medium' => 'Chegue ao aeroporto com 2 horas de antecedência',
            'low' => 'Chegue ao aeroporto com 1h30 de antecedência',
            default => 'Consulte as recomendações da companhia aérea',
        };
    }

    public function isHighTraffic(Carbon $datetime): bool
    {
        return $this->determineTrafficLevel($datetime) === 'high';
    }

    public function getPeakHours(): array
    {
        return $this->peakHours;
    }

    public function getBestDepartureWindows(Carbon $date): array
    {
        $windows = [];
        
        // Morning low traffic (before peak)
        $windows[] = [
            'start' => $date->copy()->setTime(5, 0),
            'end' => $date->copy()->setTime(6, 0),
            'traffic' => 'low',
            'label' => 'Manhã cedo - Tráfego baixo',
        ];
        
        // Mid-day moderate traffic
        $windows[] = [
            'start' => $date->copy()->setTime(10, 0),
            'end' => $date->copy()->setTime(15, 0),
            'traffic' => 'medium',
            'label' => 'Meio do dia - Tráfego moderado',
        ];
        
        // Late evening low traffic
        $windows[] = [
            'start' => $date->copy()->setTime(21, 0),
            'end' => $date->copy()->setTime(23, 59),
            'traffic' => 'low',
            'label' => 'Noite - Tráfego baixo',
        ];
        
        return $windows;
    }
}
