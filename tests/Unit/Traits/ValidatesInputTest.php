<?php

namespace Tests\Unit\Traits;

use App\Service\SunMoon\SolunarService;
use Carbon\Carbon;
use Tests\TestCase;

class ValidatesInputTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->inputs = [
            'date' => "11-02-2021",
            'timezone' => -5,
            'zip' => 78704
        ];

        $this->solunar_svc = new SolunarService;
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_date_format()
    {
        $incorrect_format = "31-10-2021";

        $this->expectExceptionMessage('Date is not formatted correctly. Must be formatted as m-d-Y');

        $this->inputs['date'] = $incorrect_format;
        $this->solunar_svc->validate($this->inputs);
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_date()
    {
        $invalid_date = "10-99-2021";

        $this->expectExceptionMessage('Date is not formatted correctly. Must be formatted as m-d-Y');

        $this->inputs['date'] = $invalid_date;
        $this->solunar_svc->validate($this->inputs);
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_date_range()
    {
        $invalid_date = Carbon::now()->addYears(2)->format('m-d-Y');

        $this->expectExceptionMessage('Date cannot be more than a year from now.');

        $this->inputs['date'] = $invalid_date;
        $this->solunar_svc->validate($this->inputs);
    }

    /**
     * @group Exceptions
     */
    public function test_throws_exception_for_invalid_timezone()
    {
        $invalid_tz = "99";

        $this->inputs['timezone'] = $invalid_tz;

        $this->expectExceptionMessage('Timezone is not valid.');
        $this->solunar_svc->validate($this->inputs);
    }
}
