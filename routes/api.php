<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\FilmsController;

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
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('v1')->group(function () {
    Route::get('/films/{episode}', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilm']);
    Route::get('/film-species/{episode}', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilmSpecies']);
    Route::get('/film-species-summary/{episode}', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilmSpeciesSummary']);
    Route::get('/people-search/{name}', [App\Http\Controllers\Api\v1\FilmsController::class, 'peopleSearch']);
    Route::get('/starships-by-person/{name}', [App\Http\Controllers\Api\v1\FilmsController::class, 'starshipsByPerson']);
    Route::get('/galaxy-population', [App\Http\Controllers\Api\v1\FilmsController::class, 'galaxyPopulation']);
});