<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TipeWashController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login convencional
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Login con Google
Route::get('/auth/google', [LoginController::class, 'googleRedirect'])->name('googleRedirect');
Route::get('/auth/callback', [LoginController::class, 'googleLogin'])->name('googleLogin');

//Rutas CRUD
Route::resource('appointments', AppointmentController::class)
    ->only(['create', 'store', 'show']);

Route::resource('appointments', AppointmentController::class)
    ->only(['index'])
    ->middleware('auth');

Route::resource('/tipe_wash', TipeWashController::class)
    ->only(['index', 'create', 'store', 'destroy']);

// Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index')->->middleware('auth');
// Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
// Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
// Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

// Route::get('/tipe_wash', [TipeWashController::class, 'index'])->name('tipe_wash.index');
// Route::get('/tipe_wash/create', [TipeWashController::class, 'create'])->name('tipe_wash.create');
// Route::post('/tipe_wash', [TipeWashController::class, 'store'])->name('tipe_wash.store');
