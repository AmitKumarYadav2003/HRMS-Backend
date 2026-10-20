<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\AnnouncementController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Authentication Routes (PUBLIC - no middleware)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');
});

// Admin Protected Routes (PRIVATE - requires auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');
    
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard');
    Route::get('/leaves', [LeaveController::class, 'index'])
    ->name('admin.leaves.index');

    Route::post('/leaves/{id}/status', [LeaveController::class, 'updateStatus'])
    ->name('admin.leaves.updateStatus');    

    Route::resource('announcements', AnnouncementController::class)
    ->names('admin.announcements')
    ->only(['index', 'create', 'store', 'destroy']);

    Route::patch('announcements/{announcement}/toggle', [AnnouncementController::class, 'toggle'])
    ->name('admin.announcements.toggle');
});