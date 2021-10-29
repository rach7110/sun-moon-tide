<?php

namespace App\ThirdPartyApi\Solunar;

/** Formats inputs for Solunar API. */
trait FormatsInput
{
    use ExtractsDate;

    private $formatted_date;
    private $formatted_timezone;
    private $formatted_location;

    public function format($date, $tz, $location)
    {
        $this->formatted_date = $this->format_date($date);
        $this->formatted_timezone = $this->format_timezone($tz);
        $this->formatted_location = $this->format_location($location);
    }

    public function get_formatted_date()
    {
        return $this->formatted_date;
    }

    public function get_formatted_timezone()
    {
        return $this->formatted_timezone;
    }

    public function get_formatted_location()
    {
        return $this->formatted_location;
    }

    /**
     * Format values to yyyymmdd format for Solunar API.
     *
     * @param int|string $date
     * @return $string $date
     */
    private function format_date($date)
    {
        $month = intval($this->month($date));
        $day = intval($this->day($date));
        $year = intval($this->year($date));

        // Month and day need proceeding zeros.
        $m = $month < 10 ? "0{$month}" : $month;
        $d = $day < 10 ? "0{$day}" : $day;

        $date = $year . $m . $d;

        return $date;
    }

    /**
     * Format timezone.
     *
     * @param string $timezone
     * @return string $tz
     */
    private function format_timezone($timezone = "0")
    {
        return strval($timezone);
    }

    /**
     * Formats a zip code to latitude and longitude.
     *
     * @param int|string $zip
     * @return string location
     */
    private function format_location($zip)
    {
        $location = $this->convertToLatLong($zip);

        return $location;
    }

    /**
     * Convert United States zip code to a latitude and longitude.
     * Zip code must be 5 digits long.
     *
     * @param string $zip
     * @return // TODO
     */
    private function convertToLatLong($zip)
    {
        $lat_long = "";
        $locations = file(\database_path() . DIRECTORY_SEPARATOR . 'zip_codes.php');

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