<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/teste', function () {
    return view('teste');   
});

Route::get('/novoteste', function () {
    return view('novoteste');
});

Route::get('/main', function () {
    return view('main');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/testet', function () {
    return view('testet');
});

Route::get('/consultatestes', function () {
    return view('consultatestes');
});

Route::get('/relatorios', function () {
    return view('relatorios');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
