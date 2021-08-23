<?php

namespace App\Service;

use App\Contracts\ClimateServiceContract;

/** Converts data from the Solunar API into a useable format. */
class SolunarService implements ClimateServiceContract
{
    /** Dataset from the external api */
    protected $dataset;

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
     * Set the dataset from the external api.
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
