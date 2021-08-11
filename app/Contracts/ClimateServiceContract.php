<?php

namespace App\Contracts;

interface ClimateServiceContract
{
    public function set_data($data);
    public function moon_rise();
    public function moon_set();
    public function sun_rise();
    public function sun_set();
    public function moon_phase();
    public function high_tides();
    public function low_tides();
}