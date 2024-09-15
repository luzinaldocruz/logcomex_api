<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\PokemonController;

Route::get('/health', [HealthController::class, 'checkHealth']);
Route::get('pokemon', [PokemonController::class, 'index']);
Route::get('/pokemon/{nameOrId}', [PokemonController::class, 'show']);
