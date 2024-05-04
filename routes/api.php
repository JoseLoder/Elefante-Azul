<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/appointments/create', [AppointmentController::class, 'apiCreate'])->name('api.appointments.create');
Route::post('/appointments/store', [AppointmentController::class, 'apiStore'])->name('api.appointments.store');
