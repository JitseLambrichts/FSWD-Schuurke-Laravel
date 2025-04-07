<?php

use App\Http\Controllers\BestellingWinkelwagenController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReserveringController;
use App\Models\Reservatie;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');
Route::get('/menu', [App\Http\Controllers\SuggestieController::class, 'index'])->name('menu');

Route::get('/nieuws', function () {
    return view('nieuws');
})->name('nieuws');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('/bestellen', [BestellingWinkelwagenController::class, 'index'])->name('bestellen')->middleware('auth');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest');

Route::get('/mijn-account', [UserController::class, 'account'])->name('mijn-account')->middleware('auth');
Route::post('/create-user', [UserController::class, 'store'])->name('create-user');
Route::post('/login', [UserController::class, 'show'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/reserveringen', [ReserveringController::class, 'index'])->name('reserveringen.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Group review routes with auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews.store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reserveringen', [ReserveringController::class, 'index'])->name('reserveringen.index');
    Route::post('/reserveringen.store', [ReserveringController::class, 'store'])->name('reserveringen.store');
    Route::get('/winkelwagen', [BestellingWinkelwagenController::class, 'index'])->name('winkelwagen.index');
    Route::post('/winkelwagen/toevoegen', [BestellingWinkelwagenController::class, 'toevoegen'])->name('winkelwagen.toevoegen');
    Route::delete('/winkelwagen/verwijderen', [BestellingWinkelwagenController::class, 'verwijderen'])->name('winkelwagen.verwijderen');
    Route::post('/winkelwagen/bestellen', [BestellingWinkelwagenController::class, 'bestellen'])->name('winkelwagen.bestellen');
    Route::get('/bestellingen-succes', [BestellingWinkelwagenController::class, 'succes'])->name('bestellingen.succes');
});
