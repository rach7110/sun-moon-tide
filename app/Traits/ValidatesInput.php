<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;

/** Validates inputs for Solunar API. */
trait ValidatesInput
{
    public function validate($inputs)
    {
        $this->validate_date($inputs['date']);
        $this->validate_timezone($inputs['timezone']);
        $this->validate_zip($inputs['zip']);
    }

    /**
     * Throw an exception if date is invalid.
     * Year can be no more than one year out.
     *
     * @pre Format of $date is n-j-Y
     * @param string $date
     * @return void
     *
     * @throws Exception if date is not valid.
     */
    private function validate_date($date)
    {
        $format = 'n-j-Y';
        $date_object = Carbon::createFromFormat($format, $date);

        // Checks the date is not more than one year out.
        if ($date_object->greaterThan(Carbon::now()->addYear())) {
            throw new Exception('Date cannot be more than a year from now.');
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


    /**
     * Throw an exception if weather buoy station ID is invalid.
     *
     * @param string|int $id
     * @return void

     * @throws Exception if zip is invalid.
     */
    private function validate_station($id)
    {
        // TODO
    }
}