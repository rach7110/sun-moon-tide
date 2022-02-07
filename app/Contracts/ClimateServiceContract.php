<?php

namespace App\Contracts;

abstract class ClimateServiceContract
{
    private $provider;
    private $dataset;

    public function validates($inputs){}
    public function format_inputs($inputs){}
    public function fetch_data($inputs){}
    public function set_data($data){}
    public function moon_rise(){}
    public function moon_set(){}
    public function sun_rise(){}
    public function sun_set(){}
    public function moon_phase(){}
}