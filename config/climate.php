<?php

return [
    'noaa' => [
        'base_url' => 'https://www.ncdc.noaa.gov/cdo-web/api/v2/datasets',
        'token' => env('NOAA_NCDC_TOKEN', null)
    ],
    'solunar' => [
        'base_url' => 'https://api.solunar.org/solunar',
    ]
];