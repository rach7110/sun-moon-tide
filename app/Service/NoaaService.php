<?php

namespace App\ThirdPartyApi;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Noaa;

class NoaaService implements ClimateServiceContract
{
    protected $dataset;

    public function __construct(Noaa $provider)
    {
        if (!$provider->get_climate_data()) {
            $provider->set_climate_data();
        }

        $this->dataset = $provider->get_climate_data();
    }

    public function moon_rise()
    {}

    public function moon_set()
    {}

    public function sun_rise()
    {}

    public function sun_set()
    {}

    public function moon_phase()
    {}

    public function high_tides()
    {}

    public function low_tides()
    {}

}
