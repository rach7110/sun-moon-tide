<?php

namespace App\ThirdPartyApi;

/** Interacts with the Solunar external API. */
class Solunar
{
    protected $date;
    protected $location;
    protected $timezone;
    protected $base_url;
    protected $token;

    public function __construct()
    {
        $this->base_url = config('climate.solunar.base_url');
        $this->token = config('climate.solunar.token');
    }

    public function set_date($date)
    {
        $this->date = $date;
    }

    public function set_location($zip)
    {
        $this->location = $this->convertToLatLong($zip);
    }

    public function set_timezone($timezone)
    {
        $this->timezone = $timezone;
    }

    protected function convertToLatLong($zip)
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
        $url =  "{$this->base_url}/{$this->date},{$this->location},{$this->timezone}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
