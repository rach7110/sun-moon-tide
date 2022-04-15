<?php

namespace Test\Unit\Tide;

use App\Service\Tide\NoaaTideService;
use Tests\Unit\Tide\NoaaTideServiceBaseCase;

class NoaaTideServiceTest extends NoaaTideServiceBaseCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->tide_svc = new NoaaTideService;
        $this->tide_svc->parse($this->api_response);
    }

    public function test_gets_high_tides()
    {
        $this->assertEquals(['11:36','21:24'], $this->tide_svc->get_high_tides());
    }

    public function test_gets_low_tides()
    {
    $this->assertEquals(['04:06','16:06'], $this->tide_svc->get_low_tides());
    }
}