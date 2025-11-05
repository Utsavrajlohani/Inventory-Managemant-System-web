<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Simple IMS routes (no auth). Root opens the products index directly.
Route::get('/', function () {
    return Auth::check() ? view('dashboard') : redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard page (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Protected resource routes
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    // Sales routes with explicit ordering
    Route::get('sales/report', [SalesReportController::class, 'index'])->name('sales.report');
    Route::get('sales/report/{period}', [SalesReportController::class, 'index'])->name('sales.report.period');
    Route::resource('sales', SaleController::class)->only(['index','create','store','show']);
});

