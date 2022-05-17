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
use Illuminate\Support\Facades\Log;

/** Requests data from NOAA buoy API and stores to file. */
class UpdateNoaaBuoys implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, NoaaBuoyStationStore, Queueable, SerializesModels;

    /** The number of times the job may be attempted */
    public $tries = 5;

    /** Filename where the buoys are stored. */
    protected $file = 'noaa_buoy_stations.txt';
    protected $filepath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $filepath = database_path("{$this->file}");
    }

    /**
     * Execute the job.
     *
     * @param App\ThirdPartyApi\NoaaBuoyStations;
     * @return void
     */
    public function handle(NoaaBuoyStations $provider)
    {
        // Fetch data from external api.
        $stations = collect($provider->fetch()->stations);

        // Parse the ids out of result.
        $ids = $stations->pluck('id')->implode(',');

        $this->store_to_file($ids, $this->filepath);

        Log::info("NoaaBuoyStations Job was executed at " . now());
    }
}
