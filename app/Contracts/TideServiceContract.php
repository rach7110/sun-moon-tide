<?php

namespace App\Contracts;

abstract class TideServiceContract
{
    private $provider;
    private $dataset;

    public function validates($inputs){}
    public function format_inputs($inputs){}
    public function fetch_data($inputs){}
    public function set_data($data){}
    public function high_tides(){}
    public function low_tides(){}
}