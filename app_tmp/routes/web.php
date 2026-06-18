<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LinkageController;
use App\Http\Controllers\VehicleController;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\VehicleClient;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest (unauthenticated) routes ------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes -----------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', function () {
        return view('dashboard', [
            'totalAdmins'   => Admin::count(),
            'totalClients'  => Client::count(),
            'totalVehicles' => Vehicle::count(),
            'totalLinkages' => VehicleClient::count(),
        ]);
    })->name('dashboard');

    // Clients (full resource CRUD)
    Route::resource('clients', ClientController::class);

    // Vehicles (full resource CRUD)
    Route::resource('vehicles', VehicleController::class);

    // Linkages (index, create, store, show, destroy)
    Route::resource('linkages', LinkageController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy'])
        ->parameters(['linkages' => 'linkage']);
});
