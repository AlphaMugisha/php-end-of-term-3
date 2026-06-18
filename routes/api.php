<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LinkageController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public authentication endpoints -----------------------------------------
Route::post('/auth/register', [AuthController::class, 'apiRegister']);
Route::post('/auth/login', [AuthController::class, 'apiLogin']);

// Protected endpoints (Bearer token required) ------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'apiLogout']);

    Route::get('/user', fn (\Illuminate\Http\Request $request) => $request->user());

    // Clients
    Route::apiResource('clients', ClientController::class);

    // Vehicles
    Route::apiResource('vehicles', VehicleController::class);

    // Linkages (index, store, show, destroy)
    Route::apiResource('linkages', LinkageController::class)
        ->only(['index', 'store', 'show', 'destroy'])
        ->parameters(['linkages' => 'linkage']);
});
