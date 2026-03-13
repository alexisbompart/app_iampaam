<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeneficiariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['role:admin,operador,consultor'])->group(function () {
        Route::resource('beneficiarios', BeneficiariosController::class);
    });

    Route::middleware(['role:admin,operador'])->group(function () {
        Route::resource('productos', ProductosController::class);
        Route::get('/ordenes', [OrdenesController::class, 'index'])->name('ordenes.index');
        Route::get('/ordenes/create/{tipo}', [OrdenesController::class, 'create'])->name('ordenes.create');
        Route::post('/ordenes/{tipo}', [OrdenesController::class, 'store'])->name('ordenes.store');
        Route::get('/ordenes/{tipo}/{id}', [OrdenesController::class, 'show'])->name('ordenes.show');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UsersController::class);
    });
});
