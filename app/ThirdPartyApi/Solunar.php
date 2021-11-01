<?php

namespace App\ThirdPartyApi;

/** Interacts with the Solunar external API. */
class Solunar
{
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->base_url = config('climate.solunar.base_url');
        $this->token = config('climate.solunar.token');
    }

    /**
     * Send a curl request to the external api.
     *
     * @return Object $response
     */
    public function fetch($date, $timezone, $location)
    {
        $url =  "{$this->base_url}/{$date},{$location},{$timezone}";  // TODO: use constant for directory sep.

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = json_decode(curl_exec($curl));

        curl_close($curl);

        return $data;
    }

}
