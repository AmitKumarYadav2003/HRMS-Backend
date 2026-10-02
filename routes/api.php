<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\HolidayController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Illuminate\Http\Request $request) {
        return $request->user();
    });
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);
    Route::get('/attendance/today', [AttendanceController::class, 'today']);

    Route::post('/leave/apply', [LeaveController::class, 'apply']);
    Route::get('/leave/history', [LeaveController::class, 'history']);

    Route::get('/payslip/history', [PayslipController::class, 'history']);
    Route::get('/holidays', [HolidayController::class, 'list']);

});