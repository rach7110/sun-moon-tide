<?php

class NoaaTideService
{

    /**
     * Gets the time of day for high or low tides from the api response.
     * @pre Data supplied contains tide values in 6 minute intervals
     * over a 24 hour 12 minute period. The data was padded by adding 6
     * minutes to the start and end of the date in case the first or last
     * value in the day is a peak tide.
     */
    private function extract_daily_tide_times($data, $tide_type) {}

    // 3 Possible scenarios for each type of tide:
        // 1 - There are two tide cycles in the day - peaks occurring between 00:06 - 23:54.
        // 2 - There are two tide cycles in the day - peaks occurring at 00:00, 12:00, or 24:00.
        // 3 - There is one tide cycle in the day.


        // NOTES for checking tide is a peak.
            // Declare peak tides array.
            // Skip first/last data points in dataset.
            // Divide the day in half.
            // First half:
                // Get min/max point
                // Compare data point to the value just before and after it.
                // If it is an inflection point.
                //      get the time of the peak and insert into tides array.
                // Else (If it is not an inflection point), get the next min/max value.
                //      If the 2nd point is an inflection point
                //          get the time of the peak and insert into tides array.
                //      Else (if it is not an inflection point),
                //          this half of the day does not have the tide we seek.

            // Second half: repeat above.


}
