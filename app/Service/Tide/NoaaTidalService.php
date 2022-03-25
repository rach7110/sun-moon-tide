<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\NoaaTides;

class NoaaTidalService extends TideServiceContract
{
    /** $provider NoaaTides Connects to the external API */
    private NoaaTides $provider;

    /** Dataset provided by the external api */
    private $dataset;

    public function __construct()
    {
        $this->provider = new NoaaTides;
    }

    public function validates($inputs){}
    public function format_inputs($inputs){}

    public function fetch_data($inputs) {
        $dataset = $this->provider->fetch(
            $inputs['date'],
            $inputs['timezone'],
            $inputs['station_id']);

            return $dataset;
    }

    /**
     * Sets the data from the external api response.
     *
     * @param string $api_response
     * @return void
     */
    public function set_data($api_response) {
        // TODO: decide if the decoding should happen on the setter or getter methods.

        $this->dataset->high_tides = $this->set_high_tides($api_response);
        $this->dataset->low_tides = $this->set_low_tides($api_response);
    }

    /**
     * Filters out the high tide data from the api response
     *
     * @return void
     */
    public function set_high_tides()
    {}

    /**
     * Filters out the low tide data from the api response
     *
     * @return void
     */
    public function set_low_tides()
    {}

    public function get_high_tides() {
        return $this->dataset->high_tides;
    }

    public function get_low_tides() {
        return $this->dataset->low_tides;
    }
}
