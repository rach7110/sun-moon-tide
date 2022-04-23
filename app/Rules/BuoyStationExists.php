<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BuoyStationExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // TODO
        // open the station list file
        $list = collect(['1611400,1612340,1612480,1615680']);
        $exists = $list->search($value);
        // if open, search for value using laravel collection method, 'search'. Would be interesting to compare time complexity of search vs custom binary search method.
            // if found, return true.
            // else, throw "Station not found" Exception.
        // Else, throw file not found error.

        return $exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not exist.';
    }
}
