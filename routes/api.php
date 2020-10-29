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

Route::get(
	'gasoline/map',
	'App\Http\Controllers\MapController@read_gasoline'
);
Route::get(
	'gasoline/map/resources',
	'App\Http\Controllers\MapController@show_read_gas'
);
Route::get(
	'munic/state/{state}',
	'App\Http\Controllers\GeographicController@show_munics'
);

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
