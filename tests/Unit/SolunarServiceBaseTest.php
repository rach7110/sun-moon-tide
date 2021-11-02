<?php
namespace Tests\Unit;

use App\Service\Solunar\SolunarService;
use Tests\TestCase;

class SolunarServiceBaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->solunar_svc = new SolunarService;
        $this->date = "11-02-2021";
        $this->timezone = -5;
        $this->zipcode = 78704;

        $this->api_response = json_decode('{"sunRise":"1:10","sunTransit":"8:16","sunSet":"15:22","moonRise":"12:55","moonTransit":"5:22","moonUnder":"17:52","moonSet":"22:43","moonPhase":"Waxing Gibbous","moonIllumination":0.8495756230964231,"sunRiseDec":1.16667,"sunTransitDec":8.2667,"sunSetDec":15.3667,"moonRiseDec":12.9166,"moonSetDec":22.7165,"moonTransitDec":5.3666,"moonUnderDec":17.8667,"minor1StartDec":12.4166,"minor1Start":"12:25","minor1StopDec":13.4166,"minor1Stop":"13:25","minor2StartDec":22.2165,"minor2Start":"22:13","minor2StopDec":23.2165,"minor2Stop":"23:13","major1StartDec":4.3666,"major1Start":"04:22","major1StopDec":6.3666,"major1Stop":"06:22","major2StartDec":16.8667,"major2Start":"16:52","major2StopDec":18.8667,"major2Stop":"18:52","dayRating":0,"hourlyRating":{"0":0,"1":20,"2":20,"3":0,"4":20,"5":20,"6":20,"7":20,"8":0,"9":0,"10":0,"11":0,"12":20,"13":20,"14":0,"15":20,"16":40,"17":20,"18":20,"19":20,"20":0,"21":0,"22":20,"23":20}}');

        $this->solunar_svc->set_data($this->api_response);

    }
}
