<?php

namespace App\ThirdPartyApi;

use App\Contracts\ClimateServiceContract;

class SolunarService implements ClimateServiceContract
{
    protected $dataset;

    public function __construct($dataset)
    {
        $this->dataset = $dataset;
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
