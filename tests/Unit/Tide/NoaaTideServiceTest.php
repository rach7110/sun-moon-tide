<?php

namespace Test\Unit\Tide;

use App\Service\Tide\NoaaTideService;
use Tests\Unit\Tide\NoaaTideServiceBaseCase;

/**
 * Tests exceptions are thrown for wrong inputs, tests formats inputs correctly, tests returned object is formatted correctly.
 */
class NoaaTideServiceTest extends NoaaTideServiceBaseCase
{
    public function setup(): void
    {
        $this->tide_svc = new NoaaTideService;

        $this->tide_svc->set_data($this->api_response);

        //  TODO set api data on service class
    }



    public function test_gets_moon_rise()
    {
    // TODO
    }

    public function test_gets_moon_set()
    {
    // TODO
    }

}