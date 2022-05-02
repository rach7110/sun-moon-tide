<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\Contracts\TideServiceContract;
use App\Rules\BuoyStationExists;
use Exception;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{

    public function fetch(Request $request, ClimateServiceContract $climate_svc, TideServiceContract $tide_svc)
    {
        $climate_dataset = [];

        // Validation: built-in Laravel validation will redirect automatically with errors.
        $validated = $request->validate([
            'date' => 'required|before:now+1year|date_format:m-d-Y',
            'zip' =>'required|postal_code:US',
            'timezone' =>'integer|between:-11,14',
            'stationId' => ['string', new BuoyStationExists],
        ]);

        $inputs = [
            'date' => $request->input('date'),
            'timezone' => $request->input('timezone', '11'),
            'zip' => $request->input('zip'),
            'station_id' => $request->input('stationId') ?? ''
        ];


        // Fetch data from external apis.
        $climate_response = $climate_svc->fetch_data($inputs);
        $climate_svc->parse($climate_response);

        $tides_response = $tide_svc->fetch_data($inputs);
        $tide_svc->parse($tides_response);

        $climate_dataset = [
            'moon_rise' => $climate_svc->get_moon_rise(),
            'moon_set' => $climate_svc->get_moon_set(),
            'sun_rise' => $climate_svc->get_sun_rise(),
            'sun_set' => $climate_svc->get_sun_set(),
            'tides_high' => $tide_svc->get_high_tides(),
            'tides_low' => $tide_svc->get_low_tides(),
            'moon_phase' => $climate_svc->get_moon_phase()
        ];

        return collect($climate_dataset);
    }
}
