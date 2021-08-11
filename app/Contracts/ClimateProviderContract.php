<?php

namespace App\Contracts;

interface ClimateProviderContract
{
    public function set_date($date);

    public function set_location($location);

    public function fetch();
}