<?php

namespace App\Contracts;

interface ClimateProviderContract
{
    public function set_date($date);

    public function set_location($location);

    public function set_climate_data();

    public function get_climate_data();
}