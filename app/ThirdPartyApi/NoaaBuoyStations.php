<?php

namespace App\ThirdPartyApi;

use GuzzleHttp\Client;

class NoaaBuoyStations
{
    // Fetch data from external api.
    public function fetch()
    {
        $url = config('climate.noaa_tide_stations.base_url');

        $client = new Client([
            'base_uri' => $url,
            'timeout' => 2.0
        ]);

        $response = $client->request('GET');
        $data = json_decode($response->getBody()->getContents());

        return $data;
    }
}
