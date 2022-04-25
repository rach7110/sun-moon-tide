<?php

namespace App\Traits;

use Exception;

trait NoaaBuoyStationStore
{
    /** Filename where the buoy is are stored. */
    protected $file = "noaa_buoy_stations.txt";

    /**
     * Stores a comma-separated list of ids to file.
     *
     * @param string $ids
     * @throws Exception
     *
     * @return void
     */
    public function store_to_file($ids)
    {
        $filepath = database_path("{$this->file}");

        if (! $file_pointer = fopen($filepath, 'w')) {
            throw new Exception('Problem updating buoy stations - cannot open storage file.');
        }

        if (fwrite($file_pointer, $ids) === false) {
            throw new Exception('Problem updating buoy stations - cannot store to file.');
        }

        fclose($file_pointer);
    }

    /**
     * Search the stored list of buoy ids for a specific value.
     *
     * @param string $id
     * @throws Exception
     *
     * @return boolean $exists;
     */
    public function find($id)
    {
        // Read the list and convert to collection.
        $contents = file_get_contents(\database_path($this->file));

        if (! $contents) {
            throw new Exception("Error opening buoy list");
        }

        $list = collect(explode(',', $contents));

        // Returns the index of the search value. Returns false if not found.
        $index = $list->search($id);

        $exists = ($index !== false);

        return $exists;
    }
}