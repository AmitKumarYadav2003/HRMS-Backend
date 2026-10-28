<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\PayrollController;

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

    Route::get('employees', [EmployeeController::class, 'index'])
    ->name('admin.employees.index');

    Route::patch('employees/{user}/toggle', [EmployeeController::class, 'toggle'])
    ->name('admin.employees.toggle');

    Route::get('employees/create', [EmployeeController::class, 'create'])
    ->name('admin.employees.create');

    Route::post('employees', [EmployeeController::class, 'store'])
    ->name('admin.employees.store');
    Route::get('employees/{user}/edit', [EmployeeController::class, 'edit'])
    ->name('admin.employees.edit');

    Route::put('employees/{user}', [EmployeeController::class, 'update'])
    ->name('admin.employees.update');

    Route::resource('holidays', HolidayController::class)
    ->names('admin.holidays')
    ->only(['index', 'create', 'store', 'destroy']);


    Route::get('payroll', [PayrollController::class, 'index'])
    ->name('admin.payroll.index');

Route::get('payroll/create', [PayrollController::class, 'create'])
    ->name('admin.payroll.create');

Route::post('payroll', [PayrollController::class, 'store'])
    ->name('admin.payroll.store');

Route::get('payroll/{payslip}', [PayrollController::class, 'show'])
    ->name('admin.payroll.show');

Route::get('payroll/{payslip}/edit', [PayrollController::class, 'edit'])
    ->name('admin.payroll.edit');

Route::put('payroll/{payslip}', [PayrollController::class, 'update'])
    ->name('admin.payroll.update');

Route::patch('payroll/{payslip}/approve', [PayrollController::class, 'approve'])
    ->name('admin.payroll.approve');
});