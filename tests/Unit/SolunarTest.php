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
        $this->solunar->format($date, $this->timezone, $this->location);

        $this->assertEquals("20211031", $this->solunar->get_formatted_date());
    }

    public function test_formats_timezone_for_solunar_api()
    {
        $tz = -11;
        $this->solunar->format($this->date, $tz, $this->location);

        $this->assertEquals("-11", $this->solunar->get_formatted_timezone($tz));
    }

    // public function test_formats_location_for_api()
    // {
    //     $zip = "78704";
    //     $output = "30.24152,-97.76877";

    //     $this->solunar->format($this->date, $this->timezone, $zip);

    //     $this->assertEquals($output, $this->solunar->get_formatted_location());
    // }
}