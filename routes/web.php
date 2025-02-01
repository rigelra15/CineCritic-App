<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CastController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// **Halaman utama bisa diakses oleh semua orang (guest & user)**
Route::get('/', function () {
    return redirect()->route('films.index');
});

// **Guest Route (Tanpa Login)**
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [AuthenticatedSessionController::class, 'register'])->name('register');
});

// **Public Access (Tanpa Login)**
Route::get('/genres/create', [GenreController::class, 'create'])->name('genres.create');
Route::resource('genres', GenreController::class)->only(['index', 'show']);
Route::get('/genres/{id}', [GenreController::class, 'show'])->name('genres.show');

Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
Route::resource('films', FilmController::class)->except(['show']);
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');

// **Casts Bisa Diakses Oleh Semua Pengguna**
Route::resource('casts', CastController::class)->only(['index', 'show']);

// **Daftar Review Per Film Bisa Diakses Semua Orang**
Route::get('/films/{film}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// **Protected Routes (Hanya untuk User yang Login)**
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // **User bisa melihat daftar review yang pernah dia buat**
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // **User bisa menambah review**
    Route::post('/films/{film}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // **Admin Only (Hanya admin yang bisa buat, edit, hapus Genre, Film, Casts)**
    Route::middleware('admin')->group(function () {
        Route::resource('genres', GenreController::class)->except(['index', 'show']);
        Route::resource('films', FilmController::class)->except(['index', 'show']);
        Route::resource('casts', CastController::class)->except(['index', 'show']);
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';
