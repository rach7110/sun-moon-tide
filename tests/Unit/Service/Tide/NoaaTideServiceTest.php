<?php

namespace Test\Unit\Service\Tide;

use App\Service\Tide\NoaaTideService;
use Tests\Unit\Service\Tide\NoaaTideServiceBaseCase;

class NoaaTideServiceTest extends NoaaTideServiceBaseCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->tide_svc1 = new NoaaTideService;
        $this->tide_svc2 = new NoaaTideService;
        $this->tide_svc1->parse($this->api_response1);
        $this->tide_svc2->parse($this->api_response2);
    }

    public function test_gets_high_tides()
    {
        $this->assertEquals(['11:36','21:24'], $this->tide_svc1->get_high_tides());
    }

    public function test_gets_low_tides()
    {
        $this->assertEquals(['04:06','16:06'], $this->tide_svc1->get_low_tides());

        //Checks edge case.
        $this->assertEquals(['00:18','16:06'], $this->tide_svc2->get_low_tides());
    }
}