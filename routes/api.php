<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/appointments/create', [AppointmentController::class, 'apiCreate'])->name('api.appointments.create');
