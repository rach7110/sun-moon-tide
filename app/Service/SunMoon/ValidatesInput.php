<?php

namespace App\Service\SunMoon;

use DateTime;
use Exception;

/** Validates inputs for Solunar API. */
trait ValidatesInput
{
    use ExtractsDate;

    public function validate($date, $tz, $location)
    {
        $this->validate_date($date);
        $this->validate_timezone($tz);
        $this->validate_zip($location);
    }

    /**
     * Throw an exception if date is invalid. Must be in month-day-year format.
     *
     * @pre Date must be in mm-dd-yyyy format.
     * @pre Date must be a valid number (ie: less than 32)
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

        if (! $date_object || $date_object->format($format) != $date) {
            throw new Exception('Date is not formatted correctly. Must be formatted as m-d-Y');
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
}