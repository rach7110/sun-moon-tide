<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\NoaaTides;

class NoaaTidalService extends TideServiceContract
{
    /** $provider NoaaTides Connects to the external API */
    private $provider;

    /** Dataset provided by the external api */
    private $dataset;

    public function __construct()
    {
        $this->provider = new NoaaTides;
    }

    public function validates($inputs){}
    public function format_inputs($inputs){}

    public function fetch_data($inputs) {
        $this->provider->fetch(
            $inputs['date'],
            $inputs['timezone'],
            $inputs['station_id']);
    }

    public function set_data($data) {
        $this->dataset = $data;
    }

    public function high_tides() {
        return $this->dataset->high_tides;
    }

    public function low_tides() {
        return $this->dataset->low_tides;
    }
}
