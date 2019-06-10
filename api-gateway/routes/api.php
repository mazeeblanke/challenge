<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BusinessDateController;

// use App\Services\BusinessDateCalculator\BusinessDateCalculator;
// use App\services\BusinessDateCalculator\Interfaces\BusinessDateCalculatorInterface;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/', function (Request $request) {
    return response()->json([
        'message'=> 'api-gateway-interface'
    ]);
});

Route::prefix('v1')->group(function () {
    Route::match(['get', 'post'], '/businessDates/getBusinessDateWithDelay', 'BusinessDateController@getBusinessDateWithDelay');
});
