<?php

namespace Tests\Integration;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;


class ClimateDataSetsTest extends TestCase
{
    /**
     * Expect a climate dataset: tide hourly level, sun hourly position, moon hourly position, and moon phase.
     * When I submit a GET request to the external weather API with a particular DATE and LOCATION
     *
     * @return void
     */
   public function test_climate_dataset_for_given_date_and_location()
   {
        $date = '2021-03-31';
        $lat = 123456;
        $long = 123456;


        $response = $this->getJson('/api/climate')
            ->assertJsonFragment(['type' => 'moon']);

        // $response = $this->get('/api/climate')
        // ->assertSee('dataset');

        // ->assertJsonCount($all_competitors->count(), 'data')
        // ->assertJsonStructure(['data' => [['type', 'id', 'attributes' => ['name', 'competitor_name', 'competitor_id', 'connected', 'zip']]]])
        // ->assertJsonFragment(['name' => $competitors->first()->name])
        // ->assertJsonFragment(['competitor_name' => $competitors->first()->competitor->name])
        // ->assertJsonFragment(['competitor_id' => $competitors->first()->competitor_id])
        // ->assertJsonFragment(['zip' => $competitors->first()->zip])
        // ->assertJsonFragment(['connected' => true]);

        // $this->visit('/api/dataset')
        //    // ->seeJsonStructure(['data' => [['type', 'attributes' => ['review', 'review_date']]]])
        //    ->seeJson(['dataset' => $hourly_tide_results['dataset']]);
   }
}
