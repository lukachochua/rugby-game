<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;

// Authentication Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);

// Player Routes (for example, creating a player)
Route::middleware('auth:sanctum')->post('/players', [PlayerController::class, 'store']);
Route::middleware('auth:sanctum')->get('/players', [PlayerController::class, 'index']);
