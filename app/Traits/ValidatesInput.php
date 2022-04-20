<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;

/** Validates inputs for Solunar API. */
trait ValidatesInput
{
    public function check($inputs)
    {
        $this->validate_station($inputs['station_id']);
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