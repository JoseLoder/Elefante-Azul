<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TipeWashController;

Route::get('/appointments/create', [AppointmentController::class, 'apiCreate'])->name('api.appointments.create');
Route::post('/appointments/store', [AppointmentController::class, 'apiStore'])->name('api.appointments.store');


Route::post('/tipe_wash/eliminarTipoLavado', [TipeWashController::class, 'eliminarTipoLavado'])->name('tipe_wash.eliminarTipoLavado');
Route::post('/tipe_wash/getListado', [TipeWashController::class, 'getListado'])->name('tipe_wash.getListado');
