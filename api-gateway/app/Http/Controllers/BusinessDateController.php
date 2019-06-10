<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Clients\LoggerHttpClient;

class BusinessDateController extends Controller
{
    public function getBusinessDateWithDelay (Request $request)
    {
        // $this->validate($request, [
        //     "delay" => "required",
        //     "initialDate" => "required"
        // ]);

        $validator = \Validator::make($request->all(), [
            "delay" => "required",
            "initialDate" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $businessCalculator = resolve('BusinessDateCalculatorInterface')
            ->setDelay($request->delay)
            ->setStartDate(new \DateTime($request->initialDate))
            ->setLocale("us")
            ->process();

        $response = [
            "businessDate" => $businessCalculator->getDate()->format('Y-m-d\TH:i:sT'),
            "totalDays" => $businessCalculator->getTotalDays(),
            "holidayDays" => $businessCalculator->getTotalHolidays(),
            "weekendDays" => $businessCalculator->getTotalFreeWeekDays()
        ];

        (new LoggerHttpClient)->createLog($response);

        return response()->json([
            "ok" => true,
            "initialQuery" => $request->all(),
            'results' => $response
        ]);
    }
}
