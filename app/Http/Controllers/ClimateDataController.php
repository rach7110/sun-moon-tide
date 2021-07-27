<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ClimateDataTransformer;

class ClimateDataController extends Controller
{
    public function index()
    {
        $dataset = [
            'dataset' => [
                'type' => 'tide',
                'units' => ['hour', 'feet above mean sea level'],
                'values' =>  [
                    0 => 1.0,
                    1 => 0.0,
                    2 => 1.0,
                    3 => 2.5,   // and so on
                ],
                [
                    'type' => 'sun',
                    'units' => ['hour', 'miles above horizon'],
                    'values' =>  [
                        0 => 1.0,
                        1 => 0.0,
                        2 => 1.0,
                        3 => 2.5,   // and so on
                    ]
                ],
                [
                    'type' => 'moon',
                    'units' => ['hour', 'miles above horizon'],
                    'values' =>  [
                        0 => 1.0,
                        1 => 0.0,
                        2 => 1.0,
                        3 => 2.5,   // and so on
                    ]
                ],
                [
                    'type' => 'moon_phase',
                    'value' => 'some_phase'
                ]
            ]
        ];

        $data = fractal()
            ->collection($dataset, new ClimateDataTransformer, 'dataset')
            ->toArray();

        return collect($dataset);
    }
}
