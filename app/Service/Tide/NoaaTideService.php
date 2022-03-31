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
     * Sets the data from the external api response.
     *
     * @param string $api_response
     * @return void
     */
    public function set_data($api_response) {
        // TODO: decide if the decoding should happen on the setter or getter methods.
        $data = $this->parse($api_response);

        $this->high_tides = $data['high_tides'];
        $this->low_tides = $data['low_tides'];
    }

    /**
     * Parse the values from the external api.
     *
     * @param Object $response
     * @return Array $data
     */
    private function parse($response)
    {
        $data = [
            'sun_rise' => $this->extract_high_tides(),
            'sun_set' => $this->extract_low_tides(),
        ];

        return $data;
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
