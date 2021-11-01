<?php

namespace Test\Unit;

use App\Service\Solunar\SolunarService;
use Tests\TestCase;

class SolunarServiceTest extends TestCase
{
    private $solunar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar_svc = new SolunarService;
        $this->date = "10-31-2021";
        $this->timezone = 9;
        $this->zipcode = 78704;
    }

    public function test_throws_exception_for_bad_dates()
    {
        $incorrect_date_format = "31-10-2021";
        $invalid_date = "10-99-2021";
        $this->expectException(\Exception::class);

        // Should throw exception if date is not formatted correctly.
        $this->solunar_svc->validate($incorrect_date_format, $this->timezone, $this->zipcode);

        // Should throw exception if date is not valid.
        $this->solunar_svc->validate($invalid_date, $this->timezone, $this->zipcode);
    }

    public function test_throws_exception_for_invalid_timezone()
    {
        $invalid_tz = "99";

        $this->expectException(\Exception::class);
        $this->solunar_svc->validate($this->date, $invalid_tz, $this->zipcode);
    }

    public function test_formats_inputs_for_solunar_api()
    {
        $inputs = [
            'date' => $this->date,
            'timezone' => $this->timezone,
            'zipcode' => $this->zipcode
        ];

        $expected = [
            'formatted_date' => '20211031',
            'formatted_timezone' => '9',
            'formatted_location' => "30.24152,-97.76877"
        ];

        $this->assertEquals($expected, $this->solunar_svc->format_inputs($inputs));
    }
}