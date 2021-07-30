<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ClimateDataTransformer;

class ClimateDataController extends Controller
{
    public function index()
    {
        $climate_dataset = [
            'dataset' => [
                    [
                        'type' => 'tide',
                        'units' => ['hour', 'feet above mean sea level'],
                        'values' =>  [
                            '1' => 1.0,
                            '2' => 1.0,
                            '3' => 2.5,   // and so on
                        ]
                    ],
                    [
                        'type' => 'sun',
                        'units' => ['hour', 'miles above horizon'],
                        'values' =>  [
                            '1' => 1.0,
                            '2' => 1.0,
                            '3' => 2.5,   // and so on
                        ]
                    ],
                    [
                        'type' => 'moon',
                        'units' => ['hour', 'miles above horizon'],
                        'values' =>  [
                            '1' => 1.0,
                            '2' => 1.0,
                            '3' => 2.5,   // and so on
                        ]
                    ],
                    [
                        'type' => 'moon_phase',
                        'value' => 'some_phase'
                    ]
            ]
        ];

        $data = fractal()
            ->collection($climate_dataset, new ClimateDataTransformer, 'climate_dataset')
            ->toArray();

        return collect($climate_dataset);
    }
}
