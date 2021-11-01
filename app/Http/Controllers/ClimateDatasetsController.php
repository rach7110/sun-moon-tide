<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\Service\Solunar\SolunarService;
use App\Transformers\ClimateDatasetTransformer;
use Exception;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{

    public function create()
    {
        // TODO: create view for form inputs.
    }

    //TODO: why not move provider to a class dependency on the service class? Change service class so it inherits an abstract class instead of an interface.
    // https://www.w3schools.com/php/php_oop_interfaces.asp
    public function fetch(Request $request, ClimateServiceContract $climate_svc)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'zip' =>'required'
        ]);

        if ($validated) {
            $date = $request->input('date');
            $tz = $request->input('timezone', '11');
            $zip = $request->input('zip');

            try {
                $climate_svc->validate($date, $tz, $zip);
            } catch (Exception $e) {
                print_r($e->getMessage()); // TODO: handle
            }

            $formatted_inputs = $climate_svc->format_inputs([
                'date' => $date,
                'timezone' => $tz,
                'zipcode' => $zip
            ]);

            $response = $climate_svc->fetch_data($formatted_inputs);
            $climate_svc->set_data($response);

            $climate_dataset = [
                'moon_rise' => $climate_svc->moon_rise(),
                'moon_set' => $climate_svc->moon_set(),
                'sun_rise' => $climate_svc->sun_rise(),
                'sun_set' => $climate_svc->sun_set(),
                'tides_high' => $climate_svc->high_tides(),
                'tides_low' => $climate_svc->low_tides(),
                'moon_phase' => $climate_svc->moon_phase()
            ];
        }

        // TODO: remove transformer. Since we are not accessing the data in multiple places in our application, all the transformation may happen in the controller.

        $data = fractal()
            ->collection($climate_dataset, new ClimateDatasetTransformer, 'climate_dataset')
            ->toArray();

        return collect($climate_dataset);
    }
}
