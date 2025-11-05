<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes for Inventory Management System
| Laravel automatically loads this file via RouteServiceProvider.
|
*/

// Root Route — safely handle logged-in and guest users
Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboard');
    }
    // Show a welcome or landing page if user not logged in
    return view('index'); // resources/views/index.blade.php
});

// ==========================
// Auth Routes
// ==========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Dashboard (Protected)
// ==========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ==========================
// Inventory Modules (Protected)
// ==========================
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);

    // Sales routes
    Route::get('sales/report', [SalesReportController::class, 'index'])->name('sales.report');
    Route::get('sales/report/{period}', [SalesReportController::class, 'index'])->name('sales.report.period');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});
