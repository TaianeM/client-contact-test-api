<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::post('/clientes', [ClientController::class, 'store'])->name('clientes.store');