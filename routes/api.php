<?php

use App\Http\Controllers\API\V1\Player\PlayerController;
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

Route::namespace('App\Http\Controllers\API\V1')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::apiResource('players', PlayerController::class)->parameters([
           'players' => 'playerId'
        ]);
    });
});
