<?php

use App\Http\Controllers\BestellingWinkelwagenController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReserveringController;
use App\Http\Controllers\MenuController;


// Get-methodes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/nieuws', function () {
    return view('nieuws');
})->name('nieuws');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');


// Post-methodes
Route::post('/create-user', [UserController::class, 'store'])->name('create-user');
Route::post('/login', [UserController::class, 'show'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


// Alle functies met middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/bestellen', [BestellingWinkelwagenController::class, 'index'])->name('bestellen');
    Route::get('/mijn-account', [UserController::class, 'account'])->name('mijn-account');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reserveringen', [ReserveringController::class, 'index'])->name('reserveringen.index');
    Route::post('/reserveringen', [ReserveringController::class, 'store'])->name('reserveringen.store');
    Route::get('/winkelwagen', [BestellingWinkelwagenController::class, 'index'])->name('winkelwagen.index');
    Route::post('/winkelwagen/toevoegen', [BestellingWinkelwagenController::class, 'toevoegen'])->name('winkelwagen.toevoegen');
    Route::delete('/winkelwagen/verwijderen', [BestellingWinkelwagenController::class, 'verwijderen'])->name('winkelwagen.verwijderen');
    Route::post('/winkelwagen/bestellen', [BestellingWinkelwagenController::class, 'bestellen'])->name('winkelwagen.bestellen');
    Route::get('/bestellingen-succes', [BestellingWinkelwagenController::class, 'succes'])->name('bestellingen.succes');
});
