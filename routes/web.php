<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
// Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
// Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
// Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');

Route::resource('appointments', AppointmentController::class)
    ->only(['index', 'create', 'store', 'show']);
