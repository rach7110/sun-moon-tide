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
    public function get_moon_rise(){}
    public function get_moon_set(){}
    public function get_sun_rise(){}
    public function get_sun_set(){}
    public function get_moon_phase(){}
}