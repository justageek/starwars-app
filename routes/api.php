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
    Route::get('/films', [App\Http\Controllers\Api\v1\FilmsController::class, 'films']);
    Route::get('/films/{film_id}', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilm']);
    Route::get('/films/{film_id}/species', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilmSpecies']);
    Route::get('/films/{film_id}/species-summary', [App\Http\Controllers\Api\v1\FilmsController::class, 'getFilmSpeciesSummary']);
    Route::get('/people/{name}/search', [App\Http\Controllers\Api\v1\FilmsController::class, 'peopleSearch']);
    Route::get('/people/{name}/starships', [App\Http\Controllers\Api\v1\FilmsController::class, 'starshipsByPerson']);
    Route::get('/galaxy-population', [App\Http\Controllers\Api\v1\FilmsController::class, 'galaxyPopulation']);
    Route::get('/planets', [App\Http\Controllers\Api\v1\FilmsController::class, 'planets']);
});