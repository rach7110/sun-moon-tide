<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\Contracts\TideServiceContract;
use App\Traits\ValidatesInput;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{
    use ValidatesInput;

    public function fetch(Request $request, ClimateServiceContract $climate_svc, TideServiceContract $tide_svc)
    {
        $climate_dataset = [];

        // Validation: built-in Laravel validation will redirect automatically with errors.
        $validated = $request->validate([
            'date' => 'required|before:now+1year',
            'zip' =>'required|postal_code:US',
            'timezone' =>'integer|between:-11,14',
        ]);


        $inputs = [
            'date' => $request->input('date'),
            'timezone' => $request->input('timezone', '11'),
            'zip' => $request->input('zip'),
            'station_id' => $request->input('stationId') ?? ''
        ];

        // Custom validation for zip codes, timezones, station, and date range.
        try {
            $this->check($inputs);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return redirect()->route('climatedata')->withInput()->withErrors($e->getMessage());
        }

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
