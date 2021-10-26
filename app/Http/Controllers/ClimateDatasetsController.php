<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Solunar;
use App\Transformers\ClimateDatasetTransformer;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{

    public function create()
    {
        // TODO: create view for form inputs.
    }

    //TODO: why not move provider to a class dependency on the service class? Change service class so it inherits an abstract class instead of an interface.
    // https://www.w3schools.com/php/php_oop_interfaces.asp
    public function fetch(Request $request, Solunar $provider, ClimateServiceContract $climate_svc)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:d-m-Y',
            'zip' =>'required'
        ]);

        if ($validated) {
            $date = $provider->format_date($request->input('date'));
            $tz = $provider->format_timezone("-11");
            $location = $provider->format_location("42.66,-84.07"); // TODO: replace lat long with zip. For testing only.

            $data = $provider->fetch($date, $tz, $location);

            $climate_svc->set_data($data);

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
        // TODO: handle validation errors.

        // TODO: remove transformer. Since we are not accessing the data in multiple places in our application, all the transformation may happen in the controller.

        $data = fractal()
            ->collection($climate_dataset, new ClimateDatasetTransformer, 'climate_dataset')
            ->toArray();

        return collect($climate_dataset);
    }
}
