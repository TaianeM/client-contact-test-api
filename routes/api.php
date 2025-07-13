<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;


Route::post('/clientes', [ClientController::class, 'store'])->name('clientes.store');
Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');
Route::put('/clientes/{id}', [ClientController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClientController::class, 'destroy'])->name('clientes.destroy');


Route::get('/clientes/{id}/contatos', [ContactController::class, 'index'])->name('contatos.index');
Route::post('/contatos', [ContactController::class, 'store'])->name('contatos.store');
Route::put('/contatos/{id}', [ContactController::class, 'update'])->name('contatos.update');
Route::delete('/contatos/{id}', [ContactController::class, 'destroy'])->name('contatos.destroy');