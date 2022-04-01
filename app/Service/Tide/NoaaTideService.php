<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\NoaaTides;
use App\Traits\FormatsInput;
use App\Traits\ValidatesInput;
use Exception;

class NoaaTideService extends TideServiceContract
{
    use FormatsInput, ValidatesInput;

    /** $provider NoaaTides Connects to the external API */
    private NoaaTides $provider;

    private $high_tides;
    private $low_tides;

    public function __construct()
    {
        $this->provider = new NoaaTides;
    }

    /**
     * Fetch data from NoaaTides API.
     *
     * @param array $inputs
     * @return array $dataset
     */
    public function fetch_data($inputs) {
        $dataset = [];

        // Validation rules.
        try {
            $this->validate($inputs);
        } catch (Exception $e) {
            print_r($e->getMessage()); // TODO: handle
        }

        $formatted = $this->format_inputs($inputs);

        $dataset = $this->provider->fetch(
            $formatted['date'],
            $formatted['timezone'],
            $formatted['station_id']
        );

        return $dataset;
    }

    /**
     * Parse the values from the external api.
     *
     * @param Object $api_response
     * @return void
     */
    //TODO does it accept an Object or string?
    public function parse($api_response) {
        $this->high_tides = $this->extract_high_tides($api_response);
        $this->low_tides =  $this->extract_low_tides($api_response);
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
