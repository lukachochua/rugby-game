<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Player Routes (for creating and listing players)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/players', [PlayerController::class, 'store']);
    Route::get('/players', [PlayerController::class, 'index']);
});

// Team Routes
Route::middleware('auth:sanctum')->group(function () {
    // CRUD operations for teams
    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::put('/teams/{team}', [TeamController::class, 'update']);
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']);

    // Add/Remove players from a team
    Route::post('/teams/{team}/add-player', [TeamController::class, 'addPlayer']);
    Route::post('/teams/{team}/remove-player', [TeamController::class, 'removePlayer']);
});
