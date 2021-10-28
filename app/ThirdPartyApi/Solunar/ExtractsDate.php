<?php

namespace App\ThirdPartyApi\Solunar;

trait ExtractsDate
{
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
}