<?php

namespace App\ThirdPartyApi;

use GuzzleHttp\Client;

/** Fetches buoy station ids from external API */
class NoaaBuoyStations
{
    /**
     * Fetch data from external api.
     *
     * @return object $data
     */
    public function fetch()
    {
        $url = config('climate.noaa_buoy_stations.base_url');

        $client = new Client([
            'base_uri' => $url,
            'timeout' => 2.0
        ]);

        $response = $client->request('GET');
        $data = json_decode($response->getBody()->getContents());

        return $data;
    }
}
