<?php

namespace App\Contracts;

abstract class TideServiceContract
{
    private $provider;

    public function validates($inputs){}
    public function format_inputs($inputs){}
    public function fetch_data($inputs){}
    public function set_data($data){}
    public function get_high_tides(){}
    public function get_low_tides(){}
}