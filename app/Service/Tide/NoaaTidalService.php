<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\NoaaTides;

class NoaaTidalService extends TideServiceContract
{
    /** $provider NoaaTides Connects to the external API */
    private NoaaTides $provider;

    private $high_tides;
    private $low_tides;

    public function __construct()
    {
        $this->provider = new NoaaTides;
    }

    //TODO - this will move to a trait.
    public function format_inputs($inputs)
    {
        // $date = $this->format_date($inputs['date']);
        // $timezone = $this->format_timezone($inputs['tz']);
        // $location = $this->format_location($inputs['zip']);

        // $formatted = [
        //     'date' => $date,
        //     'timezone' => $timezone,
        //     'location' => $location
        // ];

        // return $formatted;
    }

    //TODO - this will move to a trait.
    public function validates($inputs)
    {}

    /**
     * Fetch data from NoaaTides API.
     *
     * @param array $inputs
     * @return array $dataset
     */
    public function fetch_data($inputs) {
        $dataset = [];

        $formatted = $this->format_inputs($inputs);

        $dataset = $this->provider->fetch(
            $formatted['date'],
            $formatted['timezone'],
            $formatted['station_id']
        );

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

        $this->dataset->high_tides = $this->extract_high_tides($api_response);
        $this->dataset->low_tides = $this->extract_low_tides($api_response);
    }

    /**
     * Filters out the high tide data from the api response
     *
     * @return void
     */
    private function extract_high_tides()
    {}

    /**
     * Filters out the low tide data from the api response
     *
     * @return void
     */
    private function extract_low_tides()
    {}

    public function get_high_tides() {
        return $this->high_tides;
    }

    public function get_low_tides() {
        return $this->low_tides;
    }
}
