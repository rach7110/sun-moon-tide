<?php

namespace Test\Unit;

use Tests\Unit\SolunarServiceBaseTest;

/**
 * Tests exceptions are thrown for wrong inputs, tests formats inputs correctly, tests returned object is formatted correctly.
 */
class SolunarServiceTest extends SolunarServiceBaseTest
{
    public function test_throws_exception_for_bad_dates()
    {
        $incorrect_date_format = "31-10-2021";
        $invalid_date = "10-99-2021";
        $this->expectException(\Exception::class);

        // Should throw exception if date is not formatted correctly.
        $this->solunar_svc->validate($incorrect_date_format, $this->inputs['timezone'], $this->inputs['zipcode']);

        // Should throw exception if date is not valid.
        $this->solunar_svc->validate($invalid_date, $this->inputs['timezone'], $this->inputs['zipcode']);
    }

    public function test_throws_exception_for_invalid_timezone()
    {
        $invalid_tz = "99";

        $this->expectException(\Exception::class);
        $this->solunar_svc->validate($this->inputs['date'], $invalid_tz, $this->inputs['zipcode']);
    }

    public function test_formats_inputs_for_solunar_api()
    {
        $inputs = [
            'date' => $this->inputs['date'],
            'timezone' => $this->inputs['timezone'],
            'zipcode' => $this->inputs['zipcode']
        ];

        $expected = [
            'formatted_date' => '20211102',
            'formatted_timezone' => '-5',
            'formatted_location' => "30.24152,-97.76877"
        ];

        $this->assertEquals($expected, $this->solunar_svc->format_inputs($inputs));
    }

    public function test_gets_moon_rise_and_set()
    {
        $moon_rise = $this->solunar_svc->moon_rise();
        $moon_set = $this->solunar_svc->moon_set();

        $this->assertEquals($moon_rise, $this->api_response->moonRise);
        $this->assertEquals($moon_set, $this->api_response->moonSet);
    }

    public function test_gets_sun_rise_and_set()
    {
        $sun_rise = $this->solunar_svc->sun_rise();
        $sun_set = $this->solunar_svc->sun_set();

        $this->assertEquals($sun_rise, $this->api_response->sunRise);
        $this->assertEquals($sun_set, $this->api_response->sunSet);
    }

    public function test_gets_moon_phase()
    {
        $moon_phase = $this->solunar_svc->moon_phase();

        $this->assertEquals($moon_phase, strtolower($this->api_response->moonPhase));
    }

    // TODO
    // public function test_service_gets_tides()
    // {

    // }

}