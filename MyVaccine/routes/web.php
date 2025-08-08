<?php

use Illuminate\Support\Facades\Route;

// Controladores organizados por pastas
use App\Http\Controllers\UserController;
use App\Http\Controllers\Vaccines\VaccineController;
use App\Http\Controllers\Vaccines\StockController;
use App\Http\Controllers\Vaccines\VaccinationHistoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Posts\PostoController;
use App\Models\Post;
use App\Models\Stock;
use App\Models\Vaccine;

/*
|--------------------------------------------------------------------------
| Rotas Admin (Login / Logout)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Página inicial pública
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rotas para visitantes (não autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Rotas para usuários autenticados
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard usuário comum
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    /*
    |--------------------------------------------------------------------------
    | Rotas Admin Autenticado
    |--------------------------------------------------------------------------
    */

    // Admin Home com listagem de postos
    Route::get('/admin/home', function () {
        $posts = Post::all();
        return view('admin.home', compact('posts'));
    })->name('admin.home');

    // Admin Home de Vacinas - Rota principal com filtro opcional por post_id
    Route::get('/admin/vaccines/home/{post_id?}', [StockController::class, 'homeVaccines'])
    ->name('admin.vaccines.home');

    /*
    |--------------------------------------------------------------------------
    | Recursos de Vacinas e Estoques
    |--------------------------------------------------------------------------
    */
    Route::resource('vaccines', VaccineController::class);

    Route::resource('stock', StockController::class);

    /*
    |--------------------------------------------------------------------------
    | Histórico de vacinação
    |--------------------------------------------------------------------------
    */
    Route::get('vaccination-history', [VaccinationHistoryController::class, 'index'])->name('vaccination-history.index');
    Route::get('vaccination-history/{id}', [VaccinationHistoryController::class, 'show'])->name('vaccination-history.show');

    /*
    |--------------------------------------------------------------------------
    | Usuários
    |--------------------------------------------------------------------------
    */
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    /*
    |--------------------------------------------------------------------------
    | Postos de vacinação (Admin)
    |--------------------------------------------------------------------------
    */
    Route::resource('admin/postos', PostoController::class)->names('postos');
    Route::post('/postos', [PostoController::class, 'store'])->name('postos.store');
    Route::patch('/postos/{id}/disable', [PostoController::class, 'disable'])->name('postos.disable');
    Route::patch('/postos/{id}/activate', [PostoController::class, 'activate'])->name('postos.activate');
    Route::get('/postos/{id}/edit', [PostoController::class, 'edit'])->name('postos.edit');
    Route::put('/postos/{id}', [PostoController::class, 'update'])->name('postos.update');

    /*
    |--------------------------------------------------------------------------
    | Logout para usuário comum
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
