<?php

namespace Test\Unit;

use App\ThirdPartyApi\Solunar\Solunar;
use Tests\TestCase;

class SolunarTest extends TestCase
{
    private $solunar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar = new Solunar;
        $this->date = "10-31-2021";
        $this->timezone = "9";
        $this->location = "78704";
    }

    public function test_throws_exception_for_bad_dates()
    {
        $incorrect_date_format = "31-10-2021";
        $invalid_date = "10-99-2021";
        $this->expectException(\Exception::class);

        // Should throw exception if date is not formatted correctly.
        $this->solunar->validate($incorrect_date_format, $this->timezone, $this->location);

        // Should throw exception if date is not valid.
        $this->solunar->validate($invalid_date, $this->timezone, $this->location);
    }

    public function test_throws_exception_for_invalid_timezone()
    {
        $invalid_tz = "99";

        $this->expectException(\Exception::class);
        $this->solunar->validate($this->date, $invalid_tz, $this->location);
    }

    public function test_formats_date_for_solunar_api()
    {
        $date = "10-31-2021";

        $this->assertEquals("20211031", $this->solunar->format_date($date));
    }

    public function test_formats_timezone_for_solunar_api()
    {
        $tz = -11;

        $this->assertEquals("-11", $this->solunar->format_timezone($tz));
    }

    public function test_formats_location_for_api()
    {
        $zip = "78704";
        $expected = "30.24152,-97.76877";

        $this->assertEquals($expected, $this->solunar->format_location($zip));
    }
}