<?php

namespace App\ThirdPartyApi;
use Carbon\Carbon;

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
     * @return array $data
     */
    public function fetch($date, $timezone, $station_id)
    {
        $tz = "lst";  // returns the data in the local timezone.
        $carbon_date = Carbon::createFromFormat("m-d-Y", $date, $timezone);
        $begin_date = $carbon_date->copy()->startOfDay()->subMinutes(6);
        $end_date = $carbon_date->copy()->endOfDay()->addMinutes(7);
        $station=$station_id;

        $url = "{$this->base_url}&time_zone={$tz}&begin_date={$begin_date->format('Ymd H:i')}&end_date={$end_date->format('Ymd H:i')}&station={$station}";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

}
