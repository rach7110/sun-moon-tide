<?php

namespace App\Service\Tide;

use App\Contracts\TideServiceContract;
use App\ThirdPartyApi\Tide\NoaaTides;
use App\Traits\FormatsInput;
use Carbon\Carbon;

class NoaaTideService extends TideServiceContract
{
    use FormatsInput;

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
     * @return Object $dataset
     */
    public function fetch_data($inputs) {
        $dataset = [];

        // TODO try catch
        $dataset = $this->provider->fetch(
            $inputs['date'],
            $inputs['station_id']
        );

        return $dataset;
    }

    /**
     * Parse the values from the external api.
     * and set them as a class properties.
     *
     * @param object $response
     * @return void
     */
    public function parse($response) {
        // TODO handle converting to user's timezone.
        $this->high_tides = $this->extract_diurnal_tide_times($response->data, 'high');
        $this->low_tides =  $this->extract_diurnal_tide_times($response->data, 'low');
    }

    /**
     * Gets the times of day for high or low tides from the api response.
     * Tide can have one or two peaks in a 24 hours cycle.
     * Data was padded by adding 6 minutes to the start and end of the date.
     *
     * @param object $padded_data Data from the api response.
     * @param string $type High or Low tides.
     *
     * @return array $tide_times Contains two times or
     * one time and null for the second tide.
     */
    private function extract_diurnal_tide_times($padded_data, $type)
    {
        $tide_times = [];
        $padded_data = collect($padded_data);

        // Divide the day in half.
        $padded_data1 = $padded_data->slice(0,122)->values();
        $padded_data2 = $padded_data->slice(120)->values();

        // First half of day - get extreme tidal value.
        $tide_time1 = $this->tide_time($padded_data1, $type);
        $tide_time2 = $this->tide_time($padded_data2, $type);

        array_push($tide_times, $tide_time1, $tide_time2);

        return $tide_times;
    }

    /**
     * Gets the time of day for high or low tides from the api response.
     *
     * @param Illuminate\Support\Collection $padded_data From the external API.
     * @param string $type Type of tide (high or low)
     *
     * @return string $tide_time
     */
    private function tide_time($padded_data, $type,)

    {
        $tide_time = null;
        $size = $padded_data->count();

        // Skip first and last points in the dataset.
        $data = $padded_data->slice(1, $size-2)->values(); // Need to re-index the values after slice method.
        if ($type == 'high') {
            $tide_value = $data->max('v');
        } elseif ($type == 'low') {
            $tide_value = $data->min('v');
        }

        $index = $padded_data->search(function ($item, $key) use ($tide_value) {
            return $item->v == $tide_value;
        });

        $value_before = $padded_data->slice($index-1, 1)->values()->first()->v;
        $value_after = $padded_data->slice($index+1, 1)->values()->first()->v;

        // Check for peak tide - uses recursive method (called only twice).
        if ( $this->is_apex($tide_value, $value_before, $value_after)) {
            $tide_dataset = $padded_data->where('v', $tide_value);
            $tide_time = Carbon::createFromFormat('Y-m-d H:i', collect($tide_dataset->first())->get('t'))->toTimeString('minute');
        // Check second point for inflection point.
        } elseif ($size > 120 ) {
            $tide_time = $this->tide_time($data, $type);
        }

        return $tide_time;
    }

    /**
     * Determines if a value is a peak.
     *
     * @param string $tide_value
     * @param string $before
     * @param string $after
     *
     * @return boolean
     */
    private function is_apex($tide_value, $before, $after)
    {
        $is_max = $tide_value > $before && $tide_value > $after;
        $is_min = $tide_value < $before && $tide_value < $after;

        return $is_max || $is_min;
    }

    public function get_high_tides() {
        return $this->high_tides;
    }

    public function get_low_tides() {
        return $this->low_tides;
    }
}
