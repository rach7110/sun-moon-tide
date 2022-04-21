<?php

namespace App\Jobs;

use App\ThirdPartyApi\NoaaBuoyStations;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateNoaaBuoys implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = new NoaaBuoyStations;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
