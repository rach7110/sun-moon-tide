<?php

namespace Tests\Unit\SunMoon;

use App\Service\SunMoon\SolunarService;
use Tests\Unit\SunMoon\SunMoonServiceBaseCase;

/**
 * Tests exceptions are thrown for wrong inputs, tests formats inputs correctly, tests returned object is formatted correctly.
 */
class SolunarServiceTest extends SunMoonServiceBaseCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar_svc = new SolunarService;
        $this->solunar_svc->set_data($this->api_response);

    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_bad_date_format()
    {
        $incorrect_format = "31-10-2021";

        $this->expectExceptionMessage('Date is not formatted correctly. Must be formatted as m-d-Y');

        $this->inputs['date'] = $incorrect_format;
        $this->solunar_svc->validate($this->inputs);
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_date()
    {
        $invalid_date = "10-99-2021";

        $this->expectExceptionMessage('Date is not formatted correctly. Must be formatted as m-d-Y');

        $this->inputs['date'] = $invalid_date;
        $this->solunar_svc->validate($this->inputs);
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_timezone()
    {
        $invalid_tz = "99";

        $this->inputs['tz'] = $invalid_tz;

        $this->expectExceptionMessage('Timezone is not valid.');
        $this->solunar_svc->validate($this->inputs);
    }

    public function test_formats_inputs_for_solunar_api()
    {
        $expected = [
            'date' => '20211102',
            'timezone' => '-5',
            'location' => "30.24152,-97.76877"
        ];

        $this->assertEquals($expected, $this->solunar_svc->format_inputs($this->inputs));
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
