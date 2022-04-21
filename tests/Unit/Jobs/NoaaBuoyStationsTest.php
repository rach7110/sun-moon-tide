<?php

namespace Test\Unit\Jobs;

use App\Jobs\NoaaBuoyStations;
use Tests\Unit\Jobs\NoaaBuoyStationsBaseCase;

class NoaaBuoyStationsTest extends NoaaBuoyStationsBaseCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->buoys = new NoaaBuoyStations;
    }

    public function test_parse()
    {
        $ids = "1611400,1612340,1612480,1615680";
        $data =  $this->api_response->stations;

        $this->assertEquals($ids, $this->buoys->parse($data, 'id'));
    }

    public function test_store_to_file()
    {
        $this->buoys->store_to_file("1611400,1612340, 1612480,1615680");
    }

}
