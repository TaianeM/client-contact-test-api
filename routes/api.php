<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;


Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');
Route::post('/clientes', [ClientController::class, 'store'])->name('clientes.store');

Route::get('/contatos', [ContactController::class, 'index'])->name('contatos.index');
Route::post('/contatos', [ContactController::class, 'store'])->name('contatos.store');