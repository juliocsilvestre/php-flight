<?php

namespace Tests\Unit;

use App\Services\TrafficService;
use Carbon\Carbon;
use Tests\TestCase;

class TrafficServiceTest extends TestCase
{
    public function test_identifies_high_traffic_during_peak_hours(): void
    {
        $service = new TrafficService();
        
        // Monday 8 AM - peak hour
        $date = Carbon::create(2025, 1, 20, 8, 0, 0);
        $this->assertEquals('high', $service->determineTrafficLevel($date));
    }

    public function test_identifies_low_traffic_late_night(): void
    {
        $service = new TrafficService();
        
        // Tuesday 2 AM - off-peak
        $date = Carbon::create(2025, 1, 21, 2, 0, 0);
        $this->assertEquals('low', $service->determineTrafficLevel($date));
    }

    public function test_returns_traffic_info(): void
    {
        $service = new TrafficService();
        $date = Carbon::create(2025, 1, 20, 18, 0, 0);
        
        $info = $service->getTrafficInfo($date);

        $this->assertIsArray($info);
        $this->assertArrayHasKey('level', $info);
        $this->assertArrayHasKey('label', $info);
        $this->assertArrayHasKey('description', $info);
        $this->assertArrayHasKey('wait_time_estimate', $info);
        $this->assertArrayHasKey('recommendation', $info);
    }

    public function test_provides_best_departure_windows(): void
    {
        $service = new TrafficService();
        $date = Carbon::create(2025, 1, 20);
        
        $windows = $service->getBestDepartureWindows($date);

        $this->assertIsArray($windows);
        $this->assertNotEmpty($windows);
        $this->assertArrayHasKey('start', $windows[0]);
        $this->assertArrayHasKey('end', $windows[0]);
        $this->assertArrayHasKey('traffic', $windows[0]);
    }
}
