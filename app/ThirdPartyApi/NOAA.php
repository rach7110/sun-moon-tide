<?php

namespace App\ThirdPartyApi;

use App\Contracts\ClimateProviderContract;

class Noaa implements ClimateProviderContract
{
    protected $date;
    protected $location;

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

    /**
     * Send a curl request to the external api.
     *
     * @return array $data
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
