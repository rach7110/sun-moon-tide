<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\NoaaTides;
use App\Traits\FormatsInput;
use App\Traits\ValidatesInput;
use Carbon\Carbon;
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
        //TODO
        // try {
        //     $this->validate($inputs);
        // } catch (Exception $e) {
        //     print_r($e->getMessage()); // TODO: handle
        // }

        // TODO
        // $formatted = $this->format_inputs($inputs);
        $formatted = $inputs;

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
     * @param Object $response
     * @return void
     */
    public function parse($response) {
        $this->high_tides = $this->extract_high_tides($response);
        $this->low_tides =  $this->extract_low_tides($response);
    }

    /**
     * Filters out the high tide data from the api response
     * and sets it as a class property.
     *
     * @param Object $response
     * @return array $high_tides
     */
    private function extract_high_tides($response)
    {
        $high_tides = [];
        $data = collect($response->data);

        // Get half of the day's values. (There are 240 x 6 minute segments in a day.
        $chunks = $data->chunk(120);
        $data1 = $chunks[0];
        $data2 = $chunks[1];

        // Get the max tides from each half of the day
        // BUG this won't work for days when there is only 1 high tide.
        // Better implementation is to find the maxes in each half. Then ensure the values just before and after are less than the max. If not, disregard the max as it is not an apex.
        $max1 = $data1->max('v');
        $max2 = $data2->max('v');
        $max_dataset1 = $data1->where('v', $max1);
        $max_dataset2 = $data2->where('v', $max2);
        $first_high_tide = (collect($max_dataset1->first())->get('t'));
        $second_high_tide = (collect($max_dataset2->first())->get('t'));

        // Get time of high tides in the format 'hh:mm'
        $first_high_tide = Carbon::createFromFormat('Y-m-d H:i', $first_high_tide)->toTimeString('minute');
        $second_high_tide = Carbon::createFromFormat('Y-m-d H:i', $second_high_tide)->toTimeString('minute');

        array_push($high_tides, $first_high_tide, $second_high_tide);

        return $high_tides;
    }

    /**
     * Filters out the low tide data from the api response
     * and sets it as a class property.
     *
     * @return void
     */
    private function extract_low_tides()
    {
        // TODO
    }

    public function get_high_tides() {
        return $this->high_tides;
    }

    public function get_low_tides() {
        return $this->low_tides;
    }
}
