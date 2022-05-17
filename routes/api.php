<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\ClimateDatasetsController;
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

Route::post('/tokens/create', [ApiTokenController::class, 'store']);

Route::post('/climate', [ClimateDatasetsController::class, 'fetch'])->name('climate');

Route::post('/post', [ClimateDatasetsController::class, 'store']);
