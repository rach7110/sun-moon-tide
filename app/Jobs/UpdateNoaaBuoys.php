<?php

namespace App\Jobs;

use App\ThirdPartyApi\NoaaBuoyStations;
use App\Traits\NoaaBuoyStationStore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateNoaaBuoys implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, NoaaBuoyStationStore, Queueable, SerializesModels;

    /** The number of times the job may be attempted */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NoaaBuoyStations $provider)
    {
        // Fetch data from external api.
        $response = $provider->fetch();

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
}
