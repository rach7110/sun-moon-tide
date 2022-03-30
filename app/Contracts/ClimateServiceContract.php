<?php

namespace App\Contracts;

abstract class ClimateServiceContract
{
    private $provider;
    private $sun_set;
    private $sun_rise;
    private $moon_set;
    private $moon_rise;
    private $moon_phase;

    public function fetch_data($inputs){}
    public function set_data($data){}
    public function get_moon_rise(){}
    public function get_moon_set(){}
    public function get_sun_rise(){}
    public function get_sun_set(){}
    public function get_moon_phase(){}
}