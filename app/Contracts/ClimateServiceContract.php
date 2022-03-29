<?php

namespace App\Contracts;

abstract class ClimateServiceContract
{
    private $provider;

    public function fetch_data($inputs){}
    public function set_data($data){}
    public function get_moon_rise(){}
    public function get_moon_set(){}
    public function get_sun_rise(){}
    public function get_sun_set(){}
    public function get_moon_phase(){}
}