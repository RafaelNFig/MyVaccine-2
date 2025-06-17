<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VaccinationHistoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Página inicial pública
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas para visitantes não autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Rotas para usuários autenticados
Route::middleware('auth')->group(function () {
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    Route::get('/admin/home', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::resource('vaccines', VaccineController::class);
    Route::resource('stock', StockController::class);

    Route::get('vaccination-history', [VaccinationHistoryController::class, 'index'])->name('vaccination-history.index');
    Route::get('vaccination-history/{id}', [VaccinationHistoryController::class, 'show'])->name('vaccination-history.show');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
