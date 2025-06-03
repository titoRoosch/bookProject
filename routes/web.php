<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/books', fn () => Inertia::render('Books/Index'))->name('books.index');
    Route::get('/books/create', fn () => Inertia::render('Books/Form'))->name('books.create');
    Route::get('/books/{book}/edit', fn () => Inertia::render('Books/Form'))->name('books.edit');
    Route::get('/books/{book}', fn () => Inertia::render('Books/Show'))->name('books.show');

    Route::get('/authors', fn () => Inertia::render('Authors/Index'))->name('authors.index');
    Route::get('/authors/create', fn () => Inertia::render('Authors/Form'))->name('authors.create');
    Route::get('/authors/{author}/edit', fn () => Inertia::render('Authors/Form'))->name('authors.edit');
    Route::get('/authors/{author}', fn () => Inertia::render('Authors/Show'))->name('authors.show');

    Route::get('/dashboardBooks', fn () => Inertia::render('Dashboard/Index'))->name('dashboard');
});


Route::middleware(['auth:sanctum'])->prefix('api')->group(function () {
    
    // 📚 Rotas de livros
    Route::prefix('book')->group(function () {
        Route::get('index', [BookController::class, 'index']);
        Route::get('show/{id}', [BookController::class, 'show']);
        Route::post('store', [BookController::class, 'store']);
        Route::put('update/{id}', [BookController::class, 'update']);
        Route::delete('delete/{id}', [BookController::class, 'delete']);
    });

    // ✍️ Rotas de autores
    Route::prefix('author')->group(function () {
        Route::get('index', [AuthorController::class, 'index']);
        Route::get('show/{id}', [AuthorController::class, 'show']);
        Route::post('store', [AuthorController::class, 'store']);
        Route::put('update/{id}', [AuthorController::class, 'update']);
        Route::delete('delete/{id}', [AuthorController::class, 'delete']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
});

require __DIR__.'/auth.php';
