<?php

namespace App\Jobs;

use App\ThirdPartyApi\NoaaBuoyStations;
use Exception;

class UpdateNoaaBuoyIds
{
    private $provider;
    private $buoy_ids = [];
    private $file = "noaa_buoy_stations.txt";

    public function __construct()
    {
        $this->provider = new NoaaBuoyStations;
    }

    public function update_stations()
    {
        // Fetch data from external api.
        $response = $this->provider->fetch();

        // parse the ids out of result.
        $ids = $this->parse($response->stations, 'id');

        $this->store_to_file($ids);
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