<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/nieuws', function () {
    return view('nieuws');
})->name('nieuws');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/reviews', function () {
    return view('reviews');
})->name('reviews')->middleware('auth');

Route::get('/reserveren', function () {
    return view('reserveren');
})->name('reserveren');

Route::get('/bestellen', function () {
    return view('bestellen');
})->name('bestellen')->middleware('auth');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Beschermd met auth middleware - alleen voor ingelogde gebruikers
Route::get('/mijn-account', function () {
    return view('mijn-account');
})->name('mijn-account')->middleware('auth');

// Nieuwe routes voor gebruikersregistratie en login
Route::post('/create-user', [UserController::class, 'store'])->name('create-user');
Route::post('/login-user', [UserController::class, 'show']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');