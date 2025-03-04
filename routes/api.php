<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Player Routes (for creating and listing players)
Route::middleware('auth:sanctum')->post('/players', [PlayerController::class, 'store']);
Route::middleware('auth:sanctum')->get('/players', [PlayerController::class, 'index']);
