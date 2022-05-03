<?php

namespace App\Traits;

use DateTime;

/** Formats supplied inputs */
trait FormatsInput
{
    /**
     * Formats supplied inputs.
     *
     * @param array $inputs
     * @param string $date_format The format for the returned date.
     *  Any \DateTime format. Must include a day, month and year.
     *
     * @return array $date_format
     */
    public function format($inputs, $date_format)
    {
        $date = $this->format_date($inputs['date'], $date_format);
        $timezone = strval($inputs['timezone']);

        $formatted = [
            'date' => $date,
            'timezone' => $timezone,
        ];

        // Format the zip for Solunar api.
        if (isset($inputs['zip'])) {
            $location = $this->convertToLatLong($inputs['zip']);
            $formatted['location'] = $location;
        }

        // Format the station for Noaa Tide api.
        if (isset($inputs['station_id'])) {
            $station_id = $this->intval($inputs['station_id']);
            $formatted['station_id'] = $station_id;
        }

        return $formatted;
    }

    /**
     * Format date to supplied format.
     *
     * @pre Supplied date is formatted as m-d-Y
     * @param string $date
     *
     * @return $string $formatted_date
     */
    private function format_date($date, $format)
    {
        $date_object = DateTime::createFromFormat('m-d-Y', $date);

        $formatted_date = $date_object->format($format);

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