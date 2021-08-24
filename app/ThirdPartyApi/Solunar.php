<?php

namespace App\ThirdPartyApi;

use Exception;

/** Interacts with the Solunar external API. */
class Solunar
{
    protected $date;
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
     * @param int|string $month
     * @param int|string $day
     * @param int|string $year
     * @return void
     */
    public function set_date($month, $day, $year)
    {
        $day = trim($day, 0);
        $month = trim($month, 0);

        $is_valid_date = checkdate(intval($month), intval($day), intval($year));

        // Throw exception if date is not valid.
        if (! $is_valid_date) {
            throw new Exception('Date is not valid');
        }

        $date = $this->format_date($month, $day, $year);

        $this->date = $date;
    }

    /**
     * Format values to yyyymmdd format.
     *
     * @param int|string $month
     * @param int|string $day
     * @param int|string $year
     * @return $string $date
     */
    public function format_date($month, $day, $year)
    {
        //
        $month = $month < 10 ? "0{$month}" : $month;
        $day = $day < 10 ? "0{$day}" : $day;

        $date = $year . $month . $day;

        return $date;
    }

    public function set_location($zip)
    {
        $this->location = $this->convertToLatLong($zip);
    }

    /**
     * Set a valid timezone
     * @param string $timezone
     * @return void
     */
    public function set_timezone($timezone)
    {
        $this->timezone = $this->valid_timezone($timezone) ? $timezone : null;
    }

    /**
     * Must be between -11 to 14.
     * (Negative for timezones west of UTC and
     * positive numbers for timezones east of UTC.)
     *
     * @param string|int $tz
     * @return bool
     */
    protected function valid_timezone($tz)
    {

        $valid_format = preg_match('/^-?[0-9]/', $tz);
        $valid_range = ($tz >= -11) && ($tz <= 14);

        if (! $valid_format || ! $valid_range) {
            throw new Exception('Timezone is not valid.');
        }

        return true;
    }

    protected function convertToLatLong($zip)
    {
        // TODO
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
