<?php

namespace App\ThirdPartyApi;

/** Interacts with the NOAA external API. */
class Noaa
{
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->base_url = config('climate.noaa.base_url');
        $this->token = config('climate.noaa.token');
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

        curl_setopt($curl, CURLOPT_URL, $this->base_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
