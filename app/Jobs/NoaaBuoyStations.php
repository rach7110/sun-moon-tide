<?php

namespace App\Jobs;

use Exception;
use GuzzleHttp\Client;

//TODO: Rename class?
class NoaaBuoyStations
{
    private $buoy_ids = [];
    private $file = "noaa_buoy_stations.txt";

    public function update_stations()
    {
        // Fetch data from external api.
        $response = $this->fetch();

        // parse the ids out of result.
        $ids = $this->parse($response->stations, 'id');

        $this->store_to_file($ids);
    }

    // Fetch data from external api.
    private function fetch()
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

    /**
     * Parse values out of the data.
     *
     * @param array $data
     * @param string $type
     *
     * @return string $ids A comma-separated list of ids.
     */
    public function parse($data, $type)
    {
        $data = collect($data);
        $ids = $data->pluck($type)->implode(',');

        return $ids;
    }

    public function store_to_file($ids)
    {
        $filepath = database_path("{$this->file}");

        if (! $file_pointer = fopen($filepath, 'w')) {
            throw new Exception('Problem updating buoy stations - cannot open storage file.');
        }

        if (fwrite($file_pointer, $ids) === false) {
            throw new Exception('Problem updating buoy stations - cannot store to file.');
        }

        fclose($file_pointer);
    }

}