<?php

namespace App\ThirdPartyApi;

use App\ThirdPartyApi\ClimateProviderContract;

class Noaa implements ClimateProviderContract
{
    /**
     * Climate dataset from external api for a given date.
     *
     * @var array
     */
    public $climate_dataset;

    protected $url;

    protected $token;

    public function __construct()
    {
        $this->url = config('climate.climate_url');
        $this->token = config('climate.climate_token');
    }

    public function set_climate_data()
    {
        $success = false;
        $response = $this->fetch();

        if ($response['success']) {
            $this->climate_dataset = $response;

            return $success = true;
        }

        return $success;
    }

    public function get_climate_data()
    {
        return $this->climate_dataset;
    }

    /**
     * Send a curl request to the external api.
     *
     * @return array
     */
    public function fetch()
    {
        $header[] = "token: {$this->token}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
