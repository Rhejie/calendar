<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'calendar' ], function () {
    Route::get('get-events', [App\Http\Controllers\EventsController::class, 'getEvents']);
    Route::post('add-event', [App\Http\Controllers\EventsController::class, 'addEvent']);
});
