<?php

namespace Tests\Unit\SunMoon;

use App\Service\SunMoon\SolunarService;
use Tests\Unit\SunMoon\SolunarServiceBaseCase;

class SolunarServiceTest extends SolunarServiceBaseCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar_svc = new SolunarService;
        $this->solunar_svc->parse($this->api_response);

    }

    public function test_gets_moon_rise_and_set()
    {
        $moon_rise = $this->solunar_svc->get_moon_rise();
        $moon_set = $this->solunar_svc->get_moon_set();

        $this->assertEquals($moon_rise, $this->api_response->moonRise);
        $this->assertEquals($moon_set, $this->api_response->moonSet);
    }

    public function test_gets_sun_rise_and_set()
    {
        $sun_rise = $this->solunar_svc->get_sun_rise();
        $sun_set = $this->solunar_svc->get_sun_set();

        $this->assertEquals($sun_rise, $this->api_response->sunRise);
        $this->assertEquals($sun_set, $this->api_response->sunSet);
    }

    public function test_gets_moon_phase()
    {
        $moon_phase = $this->solunar_svc->get_moon_phase();

        $this->assertEquals($moon_phase, strtolower($this->api_response->moonPhase));
    }
}
