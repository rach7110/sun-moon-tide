<?php

use App\ThirdPartyApi\SomeTidalApi;

class SomeTidalApiService
{
    /** Provider class that connects to the external API */
    private $provider;

    /** Dataset provided by the external api */
    private $dataset;

    public function format_inputs($inputs){}
    public function fetch_data($inputs){}
    public function set_data($data){}
    public function high_tides(){}
    public function low_tides(){}
}
