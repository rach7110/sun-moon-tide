<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\Contracts\TideServiceContract;
use Exception;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{
    public function fetch(Request $request, ClimateServiceContract $climate_svc, TideServiceContract $tide_svc)
    {
        $climate_dataset = [];

        // Frontend validation
        $validated = $request->validate([
            'date' => 'required|date_format:m-d-Y',
            'zip' =>'required'
        ]);

        if (! $validated) {
                $msg = "Inputs are invalid.";

                dd($msg);
        } else {
            $date = $request->input('date');
            $tz = $request->input('timezone', '11');
            $zip = $request->input('zip');
            $station_id = $request->input('stationId') ?? '';

            // Additional validation rules.
            try {
                $climate_svc->validate($date, $tz, $zip);
                // $tide_svc->validate(); // TODO
            } catch (Exception $e) {
                dd('Error');
                print_r($e->getMessage()); // TODO: handle
            }

            // Fetch data from external apis.
            $climate_response = $climate_svc->fetch_data([
                'date' => $date,
                'timezone' => $tz,
                'zipcode' => $zip
            ]);

            $tides_response = $tide_svc->fetch_data([
                'date' => $date,
                'timezone' => $tz,
                'station_id' => $station_id
            ]);

            $climate_svc->set_data($climate_response);

            $tide_svc->set_data($tides_response);

            $climate_dataset = [
                'moon_rise' => $climate_svc->get_moon_rise(),
                'moon_set' => $climate_svc->get_moon_set(),
                'sun_rise' => $climate_svc->get_sun_rise(),
                'sun_set' => $climate_svc->get_sun_set(),
                'tides_high' => $tide_svc->get_high_tides(),
                'tides_low' => $tide_svc->get_low_tides(),
                'moon_phase' => $climate_svc->get_moon_phase()
            ];
        }

        return collect($climate_dataset);
    }
}
