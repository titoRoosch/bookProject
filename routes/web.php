<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Authors;
use App\Models\Books;

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
    Route::get('/books/{book}/edit', function (Books $book) {
        $book->load('authors');
        return Inertia::render('Books/Form', compact('book'));
    })->name('books.edit');

    Route::get('/books/{book}', function (Books $book) {
        $book->load('authors');
        return Inertia::render('Books/Show', compact('book'));
    })->name('books.show');

    Route::get('/authors', fn () => Inertia::render('Authors/Index'))->name('authors.index');
    Route::get('/authors/create', fn () => Inertia::render('Authors/Form'))->name('authors.create');
    Route::get('/authors/{author}/edit', function (Authors $author) {
        return Inertia::render('Authors/Form', compact('author'));
    })->name('authors.edit');

    Route::get('/authors/{author}', function (Authors $author) {
        return Inertia::render('Authors/Show', compact('author'));
    })->name('authors.show');

    Route::get('/dashboardBooks', fn () => Inertia::render('Dashboard/Index'))->name('dashboard');
});

require __DIR__.'/auth.php';
