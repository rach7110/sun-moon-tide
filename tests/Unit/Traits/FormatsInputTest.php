<?php

namespace Tests\Unit\Traits;

use App\Service\SunMoon\SolunarService;
use App\Service\Tide\NoaaTideService;
use App\Traits\FormatsInput;
use Tests\TestCase;

class FormatsInputTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->svc = new Class
        {
            use FormatsInput;
        };
    }

    public function test_formats_inputs_for_solunar_api()
    {
        $api = 'Solunar';

        $inputs = [
            'date' => "11-02-2021",
            'timezone' => -5,
            'zip' => 78704
        ];

        $expected = [
            'date' => '20211102',
            'timezone' => '-5',
            'location' => "30.24152,-97.76877"
        ];

        $this->assertEquals($expected, $this->svc->format($inputs, $api));
    }

    public function test_formats_inputs_for_noaa_tides_api()
    {
        $api = 'NoaaTide';

        $inputs = [
            'date' => "11-02-2021",
            'timezone' => -5,
            'station_id' => "9414290"
        ];

        $expected = [
            'date' => '20211102 00:00',
            'station_id' => 9414290
        ];

        $this->assertEquals($expected, $this->svc->format($inputs, $api));
    }
}
