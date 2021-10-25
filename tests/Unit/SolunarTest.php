<?php

namespace Test\Unit;

use Tests\TestCase;
use App\ThirdPartyApi\Solunar;

class SolunarTest extends TestCase
{
    private $solunar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar = new Solunar;
    }

    public function test_throws_exception_for_incorrect_dates()
    {
        $incorrect_date_format = "31-10-2021";
        $invalid_date = "10-99-2021";
        $this->expectException(\Exception::class);

        // Should throw exception if date is not formatted correctly.
        $this->solunar->format_and_set_date($incorrect_date_format);

        // Should throw exception if date is not valid.
        $this->solunar->format_and_set_date($invalid_date);
    }

    public function test_sets_valid_date_for_solunar_api()
    {
        $date = "10-31-2021";
        $formatted_date = "20211031";

        $this->solunar->format_and_set_date($date);

        $this->assertEquals($formatted_date, $this->solunar->get_date());
    }


}