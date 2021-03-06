<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::match(['get', 'post'], '/logger/createLog', function (Request $request) {

        $log = serialize($request->log);
        // mock the logging service
        logger($log);
        // having issues connecting to the actual Redis services at the moment
        // Redis::set('logs', $log);
    });
});
