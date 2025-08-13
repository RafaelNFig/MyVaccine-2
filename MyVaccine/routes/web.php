<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vaccines\VaccineApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Vaccines\VaccineController;
use App\Http\Controllers\Vaccines\StockController;
use App\Http\Controllers\Vaccines\VaccinationHistoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Posts\PostoController;
use App\Http\Controllers\UserControllers\PostUserController;
use App\Models\Post;

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
| Rotas públicas (não requerem autenticação)
|--------------------------------------------------------------------------
*/
Route::get('/posts', [PostUserController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostUserController::class, 'show'])->name('posts.show');

// API pública para estoque de postos
Route::get('/posts/{post}/stocks', [StockController::class, 'apiStocks'])->name('posts.stocks.api');

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
| Rotas para logout padrão (usuário comum)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas para aplicação de vacina - prefixo 'admin' sem auth
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Postos de vacinação (Admin) - CRUD completo e rotas extras
    Route::resource('postos', PostoController::class)->names('postos');
    Route::patch('postos/{id}/disable', [PostoController::class, 'disable'])->name('postos.disable');
    Route::patch('postos/{id}/activate', [PostoController::class, 'activate'])->name('postos.activate');
    Route::patch('postos/{posto}/toggle-status', [PostoController::class, 'toggleStatus'])->name('postos.toggleStatus');
    Route::get('postos/{posto}/edit', [PostoController::class, 'edit'])->name('postos.edit');

    // Página para listar usuários e aplicar vacina
    Route::get('/patients/vaccinate', [VaccineApplicationController::class, 'create'])
        ->name('admin.patients.vaccinate');

    // Salvar vacinação
    Route::post('/patients/vaccinate', [VaccineApplicationController::class, 'store'])
        ->name('admin.patients.vaccinate.store');

    // API AJAX para buscar vacinas disponíveis para um posto
    Route::get('/posts/{post}/vaccines', [VaccineApplicationController::class, 'getVaccinesByPost'])
        ->name('admin.posts.vaccines');

    // Página inicial admin (dashboard)
    Route::get('/home', function () {
        $posts = Post::all();
        return view('admin.home', compact('posts'));
    })->name('admin.home');

    // Página home de vacinas
    Route::get('/vaccines/home/{post_id?}', [VaccineController::class, 'homeVaccines'])
        ->name('admin.vaccines.home');

    // Estoque por posto (admin)
    Route::prefix('postos/{post}')->group(function () {
        Route::get('stocks', [StockController::class, 'index'])->name('stock.index');
        Route::post('stocks', [StockController::class, 'store'])->name('stock.store');
        Route::delete('stocks/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
    });

    // Recursos de Vacinas
    Route::resource('vaccines', VaccineController::class);

    // Histórico de vacinação
    Route::get('vaccination-history', [VaccinationHistoryController::class, 'index'])->name('vaccination-history.index');
    Route::get('vaccination-history/{id}', [VaccinationHistoryController::class, 'show'])->name('vaccination-history.show');

    // Usuários
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.showPosts');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Rota para carregar a página principal da aplicação de vacina fora do prefixo admin
|--------------------------------------------------------------------------
*/
Route::get('/vaccine-application', [VaccineApplicationController::class, 'index'])
    ->name('admin.vaccine.application');
