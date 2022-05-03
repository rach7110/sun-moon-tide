<?php

namespace App\Traits;

use Carbon\Carbon;
use DateTime;

/** Formats supplied inputs */
trait FormatsInput
{
    /**
     * Formats supplied inputs.
     *
     * @param array $inputs
     * @param string $api The external api that will use the formatted inputs.
     *
     * @return array $formatted
     */
    public function format($inputs, $api)
    {
        $formatted = [];

        if ($api === 'Solunar') {
            $formatted['date'] = $this->format_solunar_date($inputs['date'], $inputs['timezone']);
            $formatted['location'] = $this->convertToLatLong($inputs['zip'], $inputs['timezone']);
            $formatted['timezone'] = strval($inputs['timezone']);
        }

        if ($api === 'NoaaTide') {
            $formatted['date'] = $this->format_noaa_tide_date($inputs['date'],$inputs['timezone']);
            $formatted['station_id'] = intval($inputs['station_id'], 10);;
        }

        return $formatted;
    }

    /**
     * Format date for Solunar api.
     *
     * @pre Supplied date is formatted as m-d-Y
     * @post Date will be formatted as 'Ymd'
     *
     * @param string $date
     *
     * @return $string $formatted_date
     */
    private function format_solunar_date($date, $tz)
    {
        $date_object = Carbon::createFromFormat('m-d-Y', $date, $tz);

        $formatted_date = $date_object->format('Ymd');

        return $formatted_date;
    }

    /**
     * Format date to supplied format.
     *
     * @pre Supplied date is formatted as m-d-Y
     * @post Date will be formatted as 'Ymd 00:00'
     *
     * @param string $date
     *
     * @return $string $formatted_date
     */
    private function format_noaa_tide_date($date, $tz)
    {
        $carbon_date = Carbon::createFromFormat("m-d-Y", $date, $tz);
        $formatted_date = $carbon_date->startOfDay()->format('Ymd H:i');

        return $formatted_date;
    }

    /**
     * Convert United States zip code to a latitude and longitude.
     * Zip code must be 5 digits long.
     * Output example: "30.24152,-97.76877"
     *
     * @param string $zip
     * @return string $lat_long
     */
    private function convertToLatLong($zip)
    {
        $lat_long = "";
        $locations = file(\database_path() . DIRECTORY_SEPARATOR . 'zip_codes.php'); // TODO

        // Get index of found zip.
        $index = $this->binary_search_zipcodes($locations, 0, count($locations), $zip);
        // set lat_long to the value at that index.
        $values = explode(" ", trim($locations[$index]));
        $lat_long = \str_replace('"', '', $values[1]);

        return $lat_long;
    }

    /**
     * Performs a binary search in an array where items are formatted as such:
     * 78704 "30.24152,-97.76877"
     * (zip, "latitude, longitude")
     *
     * @param array $an_array
     * @param int $first
     * @param int $last
     * @param int $target
     * @return int $index
     */
    private function binary_search_zipcodes(&$an_array, $first, $last, $target)
    {
        $index = 0;

        if ($first > $last) {
            $index = -1; // target not in original array
        } else {
        // If target is in an_array, get the middle value of array.
            $mid = $first + ($last - $first) / 2;

            // Get the zip code at the middle of array.
            $values = explode(" ", $an_array[$mid]);
            $current_zip = $values[0];

            if ($target == $current_zip) {
                $index = $mid; // target found at an_array[mid]
            } else if ($target < $current_zip) {
                $index = $this->binary_search_zipcodes($an_array, $first, $mid - 1, $target);
            } else {
                $index = $this->binary_search_zipcodes($an_array, $mid + 1, $last, $target);
            }
        }

        return $index;
    }
}