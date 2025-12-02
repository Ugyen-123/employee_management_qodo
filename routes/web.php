<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Employee Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');


// Password Reset for Employees
Route::get('/password/forgot', [PasswordController::class, 'requestForm'])->name('password.request');
Route::post('/password/email', [PasswordController::class, 'emailLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('employees', EmployeeController::class, ['as' => 'admin']);
    });
});

// Employee Protected routes
Route::middleware('auth:employees')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Employee profile self-service (view/edit their own profile only)
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('employees.profile');
    Route::post('/profile', [EmployeeController::class, 'profileUpdate'])->name('employees.profile.update');
});
