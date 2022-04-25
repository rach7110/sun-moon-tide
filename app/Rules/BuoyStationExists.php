<?php

namespace App\Rules;

use App\Traits\NoaaBuoyStationStore;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class BuoyStationExists implements Rule
{
    use NoaaBuoyStationStore;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->find($value);
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
