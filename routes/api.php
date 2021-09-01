<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'calendar' ], function () {
    Route::get('get-events', [App\Http\Controllers\EventsController::class, 'getEvents']);
    Route::post('add-event', [App\Http\Controllers\EventsController::class, 'addEvent']);
});

