<?php

namespace App\Rules;

use App\Traits\NoaaBuoyStationStore;
use Illuminate\Contracts\Validation\Rule;

class BuoyStationExists implements Rule
{
    use NoaaBuoyStationStore;

    /** Filename where the buoys are stored. */
    protected $file = 'noaa_buoy_stations.txt';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $filepath = \database_path($this->file);

        return $this->find($value, $filepath);
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
