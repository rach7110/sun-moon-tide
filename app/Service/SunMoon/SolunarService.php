<?php

namespace App\Service\SunMoon;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\SunMoon\Solunar;
use App\Traits\FormatsInput;
use Exception;

/** Converts data from the Solunar API into a useable format. */
class SolunarService extends ClimateServiceContract
{
    use FormatsInput;

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
     * Fetch data from Solunar API.
     *
     * @param array $inputs
     * @return array $dataset
     */
    public function fetch_data($inputs)
    {
        $dataset = [];

        // TODO try catch
        $dataset = $this->provider->fetch(
            $inputs['date'],
            $inputs['timezone'],
            $inputs['location']
        );

        return $dataset;
    }

    /**
     * Parse the values from the external api.
     *
     * @param Object $response
     * @return void
     */
    public function parse($response)
    {
        $this->sun_rise = $response->sunRise;
        $this->sun_set = $response->sunSet;
        $this->moon_rise = $response->moonRise;
        $this->moon_set = $response->moonSet;
        $this->moon_phase = $this->moon_phase($response->moonPhase);
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

    /**
     * Returns a valid moon phase.
     *
     * @param string $value The moon phase from the external api.
     * @return string $moon_phase Either a valid moon
     * phase or empty value.
     */
    private function moon_phase($value)
    {
        $phase = strtolower($value);

        $moon_phase = in_array($phase, self::MOON_PHASES) ? $phase : '';

        return $moon_phase;
    }
}
