<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtworkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/dashboard', function () {
    return view('logado');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/artwork', [ArtworkController::class, 'index'])->name('artwork.index');
    Route::get('/artwork/create', [ArtworkController::class, 'create'])->name('artwork.create');
    Route::post('/artwork', [ArtworkController::class, 'store'])->name('artwork.store');
    Route::get('/artwork/{artwork}', [ArtworkController::class, 'show'])->name('artwork.show');
    Route::get('/artwork/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artwork.edit');
    Route::patch('/artwork/{artwork}', [ArtworkController::class, 'update'])->name('artwork.update');
    Route::delete('/artwork/{artwork}', [ArtworkController::class, 'destroy'])->name('artwork.destroy');
});
Route::get('/register', 'RegisteredUserController@create')->name('register');
Route::post('/register', 'RegisteredUserController@store');

require __DIR__.'/auth.php';

