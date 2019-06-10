<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiGateWayTest extends TestCase
{
    // /**
    //  * A test to check api gateway is reachable
    //  *
    //  * @return void
    //  */
    // public function testApGateWayIsReachable()
    // {
    //     $response = $this->post('/api/v1/businessDates/getBusinessDateWithDelay');

    //     $response->assertStatus(200);
    // }


    // /**
    //  * A test to check api gateway is reachable
    //  *
    //  * @return void
    //  */
    // public function testApGateWayReturnsTheRightOutput()
    // {
    //     $response = $this->json('POST', '/api/v1/businessDates/getBusinessDateWithDelay', [
    //         "initialDate" => "2018-12-12T10:10:10Z",
    //         "delay" => 3
    //       ]);

    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             "ok" => true,
    //             "initialQuery" => [
    //                 "initialDate" => "2018-12-12T10:10:10Z",
    //                 "delay" => 3
    //             ],
    //             "results" => [
    //                 "businessDate" => "2018-12-15T10:10:10Z",
    //                 "totalDays" => 4,
    //                 "holidayDays" => 1,
    //                 "weekendDays" => 0
    //             ]
    //         ]);
    // }


    /**
     * A test to check api gateway is reachable
     *
     * @return void
     */
    public function testApGateWayReturnsTheRightOutput1()
    {
        $response = $this->json('POST', '/api/v1/businessDates/getBusinessDateWithDelay', [
            "initialDate" => "2018-11-10T10:10:10Z",
            "delay" => 3
          ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "ok" => true,
                "initialQuery" => [
                    "initialDate" => "2018-11-10T10:10:10Z",
                    "delay" => 3
                ],
                "results" => [
                    "businessDate" => "2018-11-15T10:10:10Z",
                    "totalDays" => 6,
                    "holidayDays" => 1,
                    "weekendDays" => 2
                ]
            ]);
    }


    // /**
    //  * A test to check api gateway is reachable
    //  *
    //  * @return void
    //  */
    // public function testApGateWayReturnsTheRightOutput2()
    // {
    //     $response = $this->json('POST', '/api/v1/businessDates/getBusinessDateWithDelay', [
    //         "initialDate" => "2018-11-15T10:10:10Z",
    //         "delay" => 3
    //       ]);

    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             "ok" => true,
    //             "initialQuery" => [
    //                 "initialDate" => "2018-11-15T10:10:10Z",
    //                 "delay" => 3
    //             ],
    //             "results" => [
    //                 "businessDate" => "2018-11-19T10:10:10Z",
    //                 "totalDays" => 5,
    //                 "holidayDays" => 0,
    //                 "weekendDays" => 2
    //             ]
    //         ]);
    // }


    // /**
    //  * A test to check api gateway is reachable
    //  *
    //  * @return void
    //  */
    // public function testApGateWayReturnsTheRightOutput3()
    // {
    //     $response = $this->json('POST', '/api/v1/businessDates/getBusinessDateWithDelay', [
    //         "initialDate" => "2018-12-25T10:10:10Z",
    //         "delay" => 20
    //       ]);

    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             "ok" => true,
    //             "initialQuery" => [
    //                 "initialDate" => "2018-12-25T10:10:10Z",
    //                 "delay" => 20
    //             ],
    //             "results" => [
    //                 "businessDate" => "2019-01-18T10:10:10Z",
    //                 "totalDays" => 30,
    //                 "holidayDays" => 2,
    //                 "weekendDays" => 8
    //             ]
    //         ]);
    // }


}
