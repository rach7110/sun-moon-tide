<?php

namespace App\ThirdPartyApi\Solunar;

/** Formats inputs for Solunar API. */
trait FormatsInput
{
    use ExtractsDate;

    protected $formatted_date;
    protected $formatted_timezone;
    protected $formatted_location;

    public function format($date, $tz, $location)
    {
        $this->formatted_date = $this->format_date($date);
        $this->formatted_timezone = $this->format_timezone($tz);
        // $this->formatted_location = $this->format_location($location);
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
     * Formats a valid zip code to latitude and longitude.
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
        // TODO <-- HERE*************
    }

}