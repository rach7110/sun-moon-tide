<?php

namespace App\Http\Controllers;

use App\Contracts\ClimateServiceContract;
use App\ThirdPartyApi\Solunar;
use App\Transformers\ClimateDatasetTransformer;
use Illuminate\Http\Request;

class ClimateDatasetsController extends Controller
{
    public function show(Solunar $provider, ClimateServiceContract $climate_svc)
    {

        // TODO: get date from query parameters and parse.
        // TODO: get location from query parameters and parse.

        $provider->set_date("20210801");
        $provider->set_location("42.66,-84.07");
        $provider->set_timezone("-5");

        $data = $provider->fetch();

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

        // TODO: remove transformer. Since we are not accessing the data in multiple places in our application, all the transformation may happen in the controller.

        $data = fractal()
            ->collection($climate_dataset, new ClimateDatasetTransformer, 'climate_dataset')
            ->toArray();

        return collect($climate_dataset);
    }
}
