<?php

namespace App\ThirdPartyApi;

use DateTime;
use Exception;

/** Interacts with the Solunar external API. */
class Solunar
{
    protected $date;
    protected $day;
    protected $month;
    protected $year;
    protected $location;
    protected $timezone;
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->base_url = config('climate.solunar.base_url');
        $this->token = config('climate.solunar.token');
    }

    /**
     * If date is valid, set as class property.
     * Otherwise, throw an exception.
     *
     * @param int|string $date
     * @return void
     */
    public function set_date($date)
    {
        // Check the date is in the correct format
        $format = 'm-d-Y';
        $date_object = DateTime::createFromFormat($format, $date);

        if (! $date_object || !$date_object->format($format) == $date) {
            throw new Exception('Date is not formatted correctly.');
        }

        if ($this->valid_date($date)) {
            $this->date = $this->format_date();
        }
    }

    /**
     * Check date is valid. Must be in month-day-year format.
     * For example, 05-75-2002 is not a valid date.
     *
     * @param string $date
     * @return bool
     */
    private function valid_date($date)
    {
        $m = substr($date, 0, strpos($date, '-'));

        $day_substring = substr($date, strpos($date, '-') + 1);
        $d = substr($day_substring, 0, strpos($day_substring, '-'));

        $year_substring = strrchr($date, '-'); //"-2002"
        $y = substr($year_substring, strpos($year_substring,'-') + 1);

        $valid_date = checkdate($m, $d, $y);

        if (! $valid_date) {
            throw new Exception('Date is not valid');
        }

        $this->month = $m;
        $this->day = $d;
        $this->year = $y;

        return true;
    }

    /**
     * Format values to yyyymmdd format for Solunar API.
     *
     * @return $string|NULL $date
     */
    private function format_date()
    {
        if ($this->month && $this->day && $this->year) {
            $month = intval($this->month);
            $day = intval($this->day);

            // Month and day need proceeding zeros.
            $m = $month < 10 ? "0{$month}" : $month;
            $d = $day < 10 ? "0{$day}" : $day;

            $date = $this->year . $m . $d;
        }

        return $date;
    }

    /**
     * Set a valid location. Otherwise, throw an exception.
     *
     * @param int|string $date
     * @return void
     */
    public function set_location($zip)
    {
        if ($this->valid_zip($zip)) {
            $this->location = $this->convertToLatLong($zip);
        }
    }

    /**
     * Check zip is valid. Must be 5 digits.
     *
     * @param string|int $zip
     * @return bool
     */
    private function valid_zip($zip)
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
     * Set a valid timezone.
     *
     * @param string $timezone
     * @return void
     */
    public function set_timezone($timezone)
    {
        $this->timezone = $this->valid_timezone($timezone) ? $timezone : null;
    }

    /**
     * Check a timezone is valid, which must be between -11 to 14.
     * (Negative for timezones west of UTC and
     * positive numbers for timezones east of UTC.)
     *
     * @param string|int $tz
     * @return bool
     */
    private function valid_timezone($tz)
    {

        $valid_format = preg_match('/^-?[0-9]/', $tz);
        $valid_range = ($tz >= -11) && ($tz <= 14);

        if (! $valid_format || ! $valid_range) {
            throw new Exception('Timezone is not valid.');
        }

        return true;
    }

    /**
     * Send a curl request to the external api.
     *
     * @return array $data
     */
    public function fetch()
    {
        $url =  "{$this->base_url}/{$this->date},{$this->location},{$this->timezone}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
