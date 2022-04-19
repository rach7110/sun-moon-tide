<?php

namespace App\Traits;

use DateTime;
use Exception;

/** Formats inputs for Solunar API. */
trait FormatsInput
{
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
        $location = $this->format_location($inputs['zip']);

        $formatted = [
            'date' => $date,
            'timezone' => $timezone,
            'location' => $location
        ];

        return $formatted;
    }

    /**
     * Format values to yyyymmdd format for Solunar API.
     *
     * @pre Format of $date is n-j-Y
     * @param int|string $date
     * @return $string $formatted_date
     */
    public function format_date($date)
    {
        $format = 'n-j-Y';
        $date_object = DateTime::createFromFormat($format, $date);

        $formatted_date = $date_object->format('Ymd');

        return $formatted_date;
    }

    /**
     * Format timezone.
     *
     * @param string $timezone
     * @return string
     */
    public function format_timezone($timezone = "0")
    {
        return strval($timezone);
    }

    /**
     * Formats a zip code to latitude and longitude.
     *
     * @param int|string $zip
     * @return string formatted_location
     */
    public function format_location($zip)
    {
        $formatted_location = $this->convertToLatLong($zip);

        return $formatted_location;
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