<?php

namespace App\Console\Commands;

use App\Jobs\UpdateNoaaBuoys;
use Illuminate\Console\Command;

class UpdateBuoyStations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateBuoys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a request to teh NOAA api and write buoy ids to file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $update_buoys_job = new UpdateNoaaBuoys();

        $update_buoys_job->handle();

        return 0;
    }
}
