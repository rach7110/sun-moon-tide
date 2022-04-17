<?php

namespace App\ThirdPartyApi;

use Carbon\Carbon;
use GuzzleHttp\Client;

/** Interacts with the NOAA external API. */
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
     * @return Object $data
     */
    public function fetch($date, $timezone, $station_id)
    {
        $tz = "lst";  // returns the data in the local timezone.
        $carbon_date = Carbon::createFromFormat("m-d-Y", $date, $timezone);
        $begin_date = $carbon_date->copy()->startOfDay()->subMinutes(6);
        $end_date = $carbon_date->copy()->endOfDay()->addMinutes(7);
        $station=$station_id;

        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', "?time_zone={$tz}&begin_date={$begin_date->format('Ymd H:i')}&end_date={$end_date->format('Ymd H:i')}&station={$station}&product=water_level&units=english&time_zone=gmt&application=ports_screen&format=json&datum=MSL");

        $data = json_decode($response->getBody()->getContents());

        return $data;
    }

}
