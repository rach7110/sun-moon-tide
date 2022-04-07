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
    // TODO
    $high_tides = ['04:36','15:00'];
        $this->assertEquals($high_tides, $this->tide_svc->get_high_tides());
    }

    public function test_gets_low_tides()
    {
    // TODO
    }

}