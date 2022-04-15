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
     * @return Object $dataset
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
     * and set them as a class properties.
     *
     * @param Object $response
     * @return void
     */
    public function parse($response) {
        $this->high_tides = $this->extract_daily_tide_times($response->data, 'high');
        $this->low_tides =  $this->extract_daily_tide_times($response->data, 'low');
    }

    /**
     * Gets the time of day for high or low tides from the api response.
     * Data was padded by adding 6 minutes to the start and end of the date.
     *
     * @param Object $padded_data Data from the api response.
     * @param string $type High or Low tides.
     *
     * @return Array $tide_times
     */
    private function extract_daily_tide_times($padded_data, $type)
    {
        $tide_times = [];
        $padded_data1 = collect($padded_data);  // TODO need to create copies?
        $padded_data2 = collect($padded_data);

        // Divide the day in half.
        $padded_data1 = $padded_data1->splice(0,122);
        $padded_data2 = $padded_data2->splice(120);

        // First half of day - get extreme tidal value.
        $tide_time1 = $this->tide_time($padded_data1, $type);
        $tide_time2 = $this->tide_time($padded_data2, $type);

        array_push($tide_times, $tide_time1, $tide_time2);

        return $tide_times;
    }

    /**
     * Undocumented function
     *
     * @param Collection $padded_data
     * @param string $type
     * @return void
     */
    private function tide_time($padded_data, $type, $shift = 0)
    {
        print_r("\n");

        $tide_time = null;
        $size = $padded_data->count();

        // Skip first and last points in the dataset.
        $data = clone $padded_data;  // TODO need to create copy?
        $short_data = $data->slice(1, $size-2);

        if ($type == 'high') {
            $tide_value = $short_data->max('v');
        } elseif ($type == 'low') {
            $tide_value = $short_data->min('v');
        }

        $index = $padded_data->search(function ($item, $key) use ($tide_value) {
            return $item->v == $tide_value;
        });

        \var_dump("Tide Value: {$tide_value}");
        \var_dump("Index: {$index}\n");

        $before_padded_data = clone $padded_data;
        $after_padded_data = clone $padded_data;

        $value_before = $before_padded_data->splice($index+($shift-1), 1)->first()->v;
        $value_after = $after_padded_data->splice($index+($shift+1), 1)->first()->v;

        // Check for peak tide - uses recursive method (called only twice).
        if ( $this->is_apex($tide_value, $value_before, $value_after)) {
            $tide_dataset = $data->where('v', $tide_value);
            $tide_time = Carbon::createFromFormat('Y-m-d H:i', collect($tide_dataset->first())->get('t'))->toTimeString('minute');
        // Check second point for inflection point.
        } elseif ($size > 120 ) {
            $shift--;
            $tide_time = $this->tide_time($short_data, $type, $shift);
        }

        return $tide_time;
    }

    private function is_apex($tide_value, $before, $after)
    {
        \var_dump("Before: {$before}");
        \var_dump("Tide: {$tide_value}");
        \var_dump("After: {$after}");
        $is_max = $tide_value > $before && $tide_value > $after;
        $is_min = $tide_value < $before && $tide_value < $after;
        \var_dump("Is max: {$is_max}");
        \var_dump("Is min: {$is_min}");

        return $is_max || $is_min;
    }

    public function get_high_tides() {
        return $this->high_tides;
    }

    public function get_low_tides() {
        return $this->low_tides;
    }
}
