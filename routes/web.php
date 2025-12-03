<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PasswordResetController as AdminPasswordResetController;

// Root redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// EMPLOYEE ROUTES
// ============================================

// Employee Authentication (Guest)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Employee Password Reset
Route::get('/password/forgot', [PasswordController::class, 'requestForm'])->name('password.request');
Route::post('/password/email', [PasswordController::class, 'emailLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// Employee Protected Routes
Route::middleware('auth:employees')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Employee profile (self-service - view/edit their own profile only)
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('employees.profile');
    Route::post('/profile', [EmployeeController::class, 'profileUpdate'])->name('employees.profile.update');
});

// ============================================
// ADMIN ROUTES
// ============================================

// Admin Authentication (Guest)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin Password Reset (Guest)
    Route::get('/password/forgot', [AdminPasswordResetController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('/password/email', [AdminPasswordResetController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/password/reset/{token}', [AdminPasswordResetController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('/password/reset', [AdminPasswordResetController::class, 'reset'])->name('admin.password.update');
});

// Admin Protected Routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Employee Management (CRUD)
    Route::resource('employees', EmployeeController::class, ['as' => 'admin']);
    
    // Admin Profile
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [AdminAuthController::class, 'profileUpdate'])->name('admin.profile.update');
});