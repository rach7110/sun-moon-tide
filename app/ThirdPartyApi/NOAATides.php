<?php

namespace App\ThirdPartyApi;

/** Interacts with the NOAA external API. */
class NoaaTides
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = config('climate.noaa_tides.base_url');
    }

    /**
     * Send a curl request to the external api.
     *
     * @return array $data
     */
    public function fetch()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->base_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
