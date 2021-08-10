<?php

namespace App\ThirdPartyApi;

use App\Contracts\ClimateProviderContract;

class Noaa implements ClimateProviderContract
{
    protected $date;
    protected $location;

    /**
     * Climate dataset from external api for a given date.
     *
     * @var array
     */
    protected $climate_dataset;

    protected $url;

    protected $token;

    public function __construct()
    {
        $this->url = config('climate.noaa.base_url');
        $this->token = config('climate.noaa.token');
    }

    public function set_date($date)
    {
        // TODO
    }

    public function set_location($location)
    {
        // TODO
    }

    public function set_climate_data()
    {
        $success = false;
        $response = $this->fetch();

        // if ($response['success']) {  // TODO
            $this->climate_dataset = $response;

            return $success = true;
        // }

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
    protected function fetch()
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
