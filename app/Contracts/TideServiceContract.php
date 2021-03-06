<?php

namespace App\Contracts;

abstract class TideServiceContract
{
    private $provider;
    private $high_tides;
    private $low_tides;

    public function fetch_data($inputs){}
    public function parse($api_response){}
    public function get_high_tides(){}
    public function get_low_tides(){}
}