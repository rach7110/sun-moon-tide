<?php

namespace App\Service\SunMoon;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Solunar;

/** Converts data from the Solunar API into a useable format. */
class SolunarService extends ClimateServiceContract
{
    use FormatsInput, ValidatesInput;

    /** Provider class that connects to the Solunar API */
    private $provider;

    private $sun_set;
    private $sun_rise;
    private $moon_set;
    private $moon_rise;
    private $moon_phase;

    /**
     * Constructor method.
     */
    public function __construct()
    {
        $this->provider = new Solunar;
    }

    const MOON_PHASES = [
        'new',
        'waxing crescent',
        'first quarter',
        'waxing gibbous',
        'full',
        'waning gibbous',
        'third quarter',
        'waning crescent'
    ];

    /**
     * Formats inputs for the Solunar API.
     *
     * @param array $inputs
     * @return array $formatted
     */
    public function format_inputs($inputs)
    {
        $date = $this->format_date($inputs['date']);
        $timezone = $this->format_timezone($inputs['tz']);
        $location = $this->format_location($inputs['zip']);

        $formatted = [
            'date' => $date,
            'timezone' => $timezone,
            'location' => $location
        ];

        return $formatted;
    }

    /**
     * Fetch data from Solunar API.
     *
     * @param array $inputs
     * @return array $dataset
     */
    public function fetch_data($inputs)
    {
        $dataset = [];

        $formatted = $this->format_inputs($inputs);

        $dataset = $this->provider->fetch(
            $formatted['date'],
            $formatted['timezone'],
            $formatted['location']
        );

        return $dataset;
    }

    /**
     * Set the data from the Solunar API.
     *
     * @param Object $api_response
     * @return void
     */
    public function set_data($api_response)
    {
        $this->sun_rise = $api_response->sunRise;
        $this->sun_set = $api_response->sunSet;
        $this->moon_rise = $api_response->moonRise;
        $this->moon_set = $api_response->moonSet;
        $this->moon_phase = $this->moon_phase($api_response->moonPhase);

    }

    /**
     * Ensure the moon phase from the external api is
     * valid by comparing to the enumerations in
     * this class.
     *
     * @param string $api_value The moon phase from the api.
     * @return string $moon_phase Either a valid moon
     * phase or empty value.
     */
    protected function moon_phase($api_value)
    {
        $phase = strtolower($api_value);

        $moon_phase = in_array($phase, self::MOON_PHASES) ? $phase : '';

        return $moon_phase;
    }

    public function get_sun_rise()
    {
        return $this->sun_rise;
    }

    public function get_sun_set()
    {
        return $this->sun_set;
    }

    public function get_moon_rise()
    {
        return $this->moon_rise;
    }

    public function get_moon_set()
    {
        return $this->moon_set;

    }

    public function get_moon_phase()
    {
        return $this->moon_phase;

    }
}
