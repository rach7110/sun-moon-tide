<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ClimateDatasetServiceTest extends TestCase
{
    /**
     * Expect a dataset of the tide’s level relative to sea level for each hour of the day.
     * When I submit a GET request to the external weather API with a particular DATE and LOCATION
     *
     * @return void
     */
    public function test_api_gets_hourly_tide_levels_for_given_date_and_location()
    {
        $date = '2021-03-31';
        $lat = 123456;
        $long = 123456;

        $hourly_tide_results = [
            'units' => [
                'hour',
                'feet'
            ],
            'dataset' => [
                0 => 1.0,
                1 => 0.0,
                2 => 1.0,
                3 => 2.5,   // and so on
            ]
         ];

    }

    /**
     * Expect a dataset of the sun's position relative to the horizon for each hour of the day.
     * When I submit a GET request to the external weather API with a particular DATE and LOCATION
     *
     * @return void
     */
    public function test_api_gets_hourly_sun_position_for_given_date_and_location()
    {
        // TODO
    }

    /**
     * Expect a dataset of the moon's position relative to the horizon for each hour of the day.
     * When I submit a GET request to the external weather API with a particular DATE and LOCATION
     *
     * @return void
     */
    public function test_api_gets_hourly_moon_position_for_given_date_and_location()
    {
        // TODO
    }

    /**
     * Expect the moon's phase.
     * When I submit a GET request to the external weather API with a particular DATE and LOCATION
     *
     * @return void
     */
    public function test_api_gets_moon_phase_for_given_date_and_location()
    {
        // TODO
    }

}
