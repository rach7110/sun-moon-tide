<?php

namespace App\Service\Solunar;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Solunar;

/** Converts data from the Solunar API into a useable format. */
class SolunarService implements ClimateServiceContract
{
    use FormatsInput, ValidatesInput;

    /** Provider class that connects to the Solunar API */
    private $provider;

    /** Dataset from the Solunar API */
    private $dataset;

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
        $timezone = $this->format_timezone($inputs['timezone']);
        $location = $this->format_location($inputs['zipcode']);

        $formatted = [
            'formatted_date' => $date,
            'formatted_timezone' => $timezone,
            'formatted_location' => $location
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
        $dataset = $this->provider->fetch(
            $inputs['formatted_date'],
            $inputs['formatted_timezone'],
            $inputs['formatted_location']
    );

        return $dataset;
    }

    /**
     * Set the dataset from the Solunar API.
     *
     * @param array $dataset
     * @return void
     */
    public function set_data($dataset)
    {
        $this->dataset = $dataset;
    }

    public function moon_rise()
    {
        return $this->dataset->moonRise;
    }

    public function moon_set()
    {
        return $this->dataset->moonSet;

    }

    public function sun_rise()
    {
        return $this->dataset->sunRise;
    }

    public function sun_set()
    {
        return $this->dataset->sunSet;
    }

    public function moon_phase()
    {
        $phase = strtolower($this->dataset->moonPhase);

        $moon_phase = in_array($phase, self::MOON_PHASES) ? $phase : '';

        return $moon_phase;
    }

    public function high_tides()
    {}

    public function low_tides()
    {}

}
