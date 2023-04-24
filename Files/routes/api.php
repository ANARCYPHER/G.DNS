<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('api')->prefix('v1/{key}')->group(function () {
    Route::get('/servers', [ApiController::class, 'servers']);
    Route::get('/dns/{domain}/{type}/{id}', [ApiController::class, 'dns']);
    Route::get('/whois/{domain}', [ApiController::class, 'whois']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
