<?php

namespace App\ThirdPartyApi;

interface ClimateProviderContract
{
    public function set_climate_data();

    public function get_climate_data();
}