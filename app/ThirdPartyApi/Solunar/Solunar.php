<?php

namespace App\ThirdPartyApi\Solunar;

/** Interacts with the Solunar external API. */
class Solunar
{
    use FormatsInput, ValidatesInput;

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
     * @param string $date
     * @param string $tz
     * @param string $location
     * @return array $data
     */
    public function fetch($date, $tz, $location)
    {
        $url =  "{$this->base_url}/{$date},{$location},{$tz}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
