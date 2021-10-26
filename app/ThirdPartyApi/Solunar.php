<?php

namespace App\ThirdPartyApi;

use DateTime;
use Exception;

/** Interacts with the Solunar external API. */
class Solunar
{
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->base_url = config('climate.solunar.base_url');
        $this->token = config('climate.solunar.token');
    }

    /**
     * Format values to yyyymmdd format for Solunar API.
     *
     * @param int|string $date
     * @return $string $date
     */
    public function format_date($date)
    {
        $this->validate_date($date);
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
     * Throw an exception if date is invalid. Must be in month-day-year format.
     * And must be valid numbers.
     * For example, 05-75-2002 is not a valid date.
     * Otherwise,
     *
     * @param string $date
     * @return void
     *
     * @throws Exception if date is not formatted correctly.
     * @throws Exception if date is not valid.
     */
    private function validate_date($date)
    {
        // Check the date is in the correct format
        $format = 'm-d-Y';
        $date_object = DateTime::createFromFormat($format, $date);

        if (! $date_object || !$date_object->format($format) == $date) {
            throw new Exception('Date is not formatted correctly. Must be m-d-Y');
        }

        // Get month, day, and year.
        $m = $this->month($date);
        $d = $this->day($date);
        $y = $this->year($date);

        // Check date contains valid numbers.
        $valid_date = checkdate($m, $d, $y);

        if (! $valid_date) {
            throw new Exception('Date is not valid');
        }

        return true;
    }

    /**
     * Formats a valid zip code to latitude and longitude.
     *
     * @param int|string $zip
     * @return string location
     */
    public function format_location($zip)
    {
        $this->validate_zip($zip);

        $location = $this->convertToLatLong($zip);

        return $location;
    }

    /**
     * Throw an exception if zip is invalid. Must be 5 digits.
     *
     * @param string|int $zip
     * @return void

     * @throws Exception if zip is invalid.
     */
    private function validate_zip($zip)
    {
        // TODO
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
        // TODO
    }

    /**
     * Format valid timezone.
     *
     * @param string $timezone
     * @return string $tz
     */
    public function format_timezone($timezone = "0")
    {
        $this->validate_timezone($timezone);

        return strval($timezone);
    }

    /**
     * Check a timezone is valid, which must be between -11 to 14.
     * (Negative for timezones west of UTC and
     * positive numbers for timezones east of UTC.)
     *
     * @param string|int $tz
     * @return void
     *
     * @throws Exception if timezone is not valid.
     */
    private function validate_timezone($tz)
    {
        $valid_format = preg_match('/^-?[0-9]/', $tz);
        $valid_range = ($tz >= -11) && ($tz <= 14);

        if (! $valid_format || ! $valid_range) {
            throw new Exception('Timezone is not valid.');
        }
    }

    /**
     * Get the numeric month from a date in mm-dd-yyyy format.
     *
     * @param string $date
     * @return int $month
     */
    private function month($date)
    {
        return substr($date, 0, strpos($date, '-'));
    }

    /**
     * Get the numeric day from a date in mm-dd-yyyy format.
     *
     * @param string $date
     * @return int $day
     */
    private function day($date)
    {
        $day_substring = substr($date, strpos($date, '-') + 1);
        $day = substr($day_substring, 0, strpos($day_substring, '-'));

        return $day;
    }
    /**
     * Get the year from a date in mm-dd-yyyy format.
     *
     * @param string $date
     * @return int $year
     */
    private function year($date)
    {
        $year_substring = strrchr($date, '-'); //"-2002"
        $year = substr($year_substring, strpos($year_substring,'-') + 1);

        return $year;
    }

    /**
     * Send a curl request to the external api.
     *
     * @param string $date
     * @param string $tz
     * @param string $location
     * @return array $data
     */
    public function fetch($date, $tz, $location)
    {
        $url =  "{$this->base_url}/{$date},{$location},{$tz}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
