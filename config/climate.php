<?php

return [
    'noaa' => [
        'base_url' => 'https://www.ncdc.noaa.gov/cdo-web/api/v2/datasets',
        'token' => env('NOAA_NCDC_TOKEN', null)
    ],
    'noaa_tides' => [
        'base_url' => 'https://api.tidesandcurrents.noaa.gov/api/prod/datagetter'
    ],
    'noaa_tide_stations' => [
        'base_url' => 'https://api.tidesandcurrents.noaa.gov/mdapi/prod/webapi/stations.json'
    ],
    'solunar' => [
        'base_url' => 'https://api.solunar.org/solunar',
    ]
];