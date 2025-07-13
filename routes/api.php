<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;


Route::post('/clientes', [ClientController::class, 'store'])->name('clientes.store');
Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');

Route::post('/contatos', [ContactController::class, 'store'])->name('contatos.store');
Route::get('/clientes/{id}/contatos', [ContactController::class, 'index'])->name('contatos.index');
