<?php

namespace App\Service\SunMoon;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Solunar;
use Exception;
use Traits\FormatsInput;
use Traits\ValidatesInput;

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
     * Fetch data from Solunar API.
     *
     * @param array $inputs
     * @return array $dataset
     */
    public function fetch_data($inputs)
    {
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
        $data = $this->parse($api_response);

        $this->sun_rise = $data['sun_rise'];
        $this->sun_set = $data['sun_set'];
        $this->moon_rise = $data['moon_rise'];
        $this->moon_set = $data['moon_set'];
        $this->moon_phase = $data['moon_phase'];
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
     * Parse the values from the external api.
     *
     * @param Object $response
     * @return Array $data
     */
    private function parse($response)
    {
        $data = [
            'sun_rise' => $response->sunRise,
            'sun_set' => $response->sunSet,
            'moon_rise' => $response->moonRise,
            'moon_set' => $response->moonSet,
            'moon_phase' => $this->moon_phase($response->moonPhase)
        ];

        return $data;
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
