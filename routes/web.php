<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Profil Toko POS Barokah Mart';
})->name('about');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');
 
Route::post('/login', [LoginController::class, 'store'])


    ->middleware('guest')
    ->name('login.store');
 
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('report.sales');
    Route::get('/users', function () {
        return 'Kelola Akun Kasir';
    })->name('users.index');
});
 
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
   Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
   Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
   Route::get('/pos/history', [PosController::class, 'history'])->name('pos.history');
});

