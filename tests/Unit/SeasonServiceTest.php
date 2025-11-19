<?php

namespace Tests\Unit;

use App\Services\SeasonService;
use Carbon\Carbon;
use Tests\TestCase;

class SeasonServiceTest extends TestCase
{
    public function test_identifies_high_season(): void
    {
        $service = new SeasonService();
        
        // December - high season
        $date = Carbon::create(2025, 12, 15);
        $this->assertTrue($service->isHighSeason($date));
        $this->assertEquals('high', $service->determineSeasonType($date));
    }

    public function test_identifies_low_season(): void
    {
        $service = new SeasonService();
        
        // April - low season
        $date = Carbon::create(2025, 4, 15);
        $this->assertFalse($service->isHighSeason($date));
        $this->assertEquals('low', $service->determineSeasonType($date));
    }

    public function test_returns_season_info(): void
    {
        $service = new SeasonService();
        $date = Carbon::create(2025, 7, 15);
        
        $info = $service->getSeasonInfo($date);

        $this->assertIsArray($info);
        $this->assertArrayHasKey('type', $info);
        $this->assertArrayHasKey('label', $info);
        $this->assertArrayHasKey('description', $info);
        $this->assertEquals('high', $info['type']);
    }
}
