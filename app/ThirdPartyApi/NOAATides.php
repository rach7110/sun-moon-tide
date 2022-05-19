<?php

namespace App\ThirdPartyApi;

use Carbon\Carbon;
use GuzzleHttp\Client;

/** Fetches tidal data from the NOAA external API. */
class NoaaTides
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = config('climate.noaa_tides.base_url');
    }

    /**
     * Send a curl request to the external api.
     *
     * @param Carbon\Carbon $date
     * @param [type] $timezone
     * @param [type] $station_id
     * @return void
     */
    public function fetch($date, $station_id)
    {
        $tz = "lst";  // returns the data in the local timezone of the station.
        // TODO include user's timezone in Carbon object.
        $carbon_date = Carbon::createFromFormat('Ymd H:i', $date);

        $begin_date = $carbon_date->copy()->subMinutes(6);
        $end_date = $carbon_date->copy()->endOfDay()->addMinutes(7);
        $station=$station_id;

        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', "?product=water_level&units=english&application=rachelL&format=json&datum=MSL&time_zone={$tz}&begin_date={$begin_date}&end_date={$end_date}&station={$station}");

        $data = json_decode($response->getBody()->getContents());

        return $data;
    }

}
