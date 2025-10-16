<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Driver\DriverJobController;
use App\Http\Middleware\RoleMiddleware;

// Authentication routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Protected routes
// Admin routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/jobs', [AdminJobController::class, 'listJobs']);
    Route::post('/jobs', [AdminJobController::class, 'createJob']);
    Route::put('/jobs/{id}', [AdminJobController::class, 'modifyJob']);
    Route::delete('/jobs/{id}', [AdminJobController::class, 'deleteJob']);
    Route::post('/jobs/{id}/assign', [AdminJobController::class, 'assignJobToDriver']);
    Route::get('/drivers', [AdminJobController::class, 'listDrivers']);
});

// Driver routes
Route::middleware(['auth', RoleMiddleware::class . ':driver'])->prefix('driver')->group(function () {
    Route::get('/jobs', [DriverJobController::class, 'myJobs']);
    Route::patch('/jobs/{id}/status', [DriverJobController::class, 'updateJobStatus']);
});
