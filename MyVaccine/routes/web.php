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
| Rota fora do grupo admin para carregar a página de aplicação de vacina
|--------------------------------------------------------------------------
| (Manter fora do grupo admin para evitar problema de carregamento)
*/
Route::get('/vaccine-application', [VaccineApplicationController::class, 'index'])
    ->name('admin.vaccine.application');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas admin sem autenticação para aplicação de vacina
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/patients/vaccinate', [VaccineApplicationController::class, 'create'])
        ->name('admin.patients.vaccinate');

    Route::post('/patients/vaccinate', [VaccineApplicationController::class, 'store'])
        ->name('admin.patients.vaccinate.store');

    // Rota AJAX para obter vacinas disponíveis para um posto
    Route::get('/posts/{post}/vaccines', [VaccineApplicationController::class, 'getVaccinesByPost'])
        ->name('admin.posts.vaccines');
});

/*
|--------------------------------------------------------------------------
| Rotas para usuários autenticados (admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard admin com listagem de postos
    Route::get('/home', function () {
        $posts = Post::all();
        return view('admin.home', compact('posts'));
    })->name('admin.home');

    // Admin Home de Vacinas - tela geral
    Route::get('/vaccines/home/{post_id?}', [VaccineController::class, 'homeVaccines'])
    ->name('admin.vaccines.home');

    /*
    |--------------------------------------------------------------------------
    | Estoque por posto
    |--------------------------------------------------------------------------
    */
    Route::prefix('postos/{post}')->group(function () {
        Route::get('stocks', [StockController::class, 'index'])->name('stock.index');
        Route::post('stocks', [StockController::class, 'store'])->name('stock.store');
        Route::delete('stocks/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Recursos de Vacinas
    |--------------------------------------------------------------------------
    */
    Route::resource('vaccines', VaccineController::class);

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
    Route::resource('postos', PostoController::class)->names('postos');

    // Rotas extras para postos
    Route::patch('postos/{id}/disable', [PostoController::class, 'disable'])->name('postos.disable');
    Route::patch('postos/{id}/activate', [PostoController::class, 'activate'])->name('postos.activate');
    Route::patch('postos/{posto}/toggle-status', [PostoController::class, 'toggleStatus'])->name('postos.toggleStatus');
});
