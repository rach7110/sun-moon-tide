<?php

namespace Test\Unit\Jobs;

use App\Traits\NoaaBuoyStationStore;
use Tests\TestCase;

class NoaaBuoyStationStoreTest extends TestCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->buoy_store = new class {
            use NoaaBuoyStationStore;
        };
        $this->filepath = './buoys_test.txt';
    }

    public function test_store_to_file()
    {
        $buoys = "1,2,3";

        $this->buoy_store->store_to_file($buoys, $this->filepath);

        $contents = file_get_contents($this->filepath);

        $this->assertEquals($buoys, $contents);
    }

    public function test_finds_id()
    {
        $this->assertTrue($this->buoy_store->find('2', $this->filepath));

        // Remove test file.
        \unlink($this->filepath);
    }
}
