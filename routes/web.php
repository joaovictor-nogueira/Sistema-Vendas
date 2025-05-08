<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/venda',VendaController::class);
    Route::resource('/cliente',ClienteController::class);
    Route::resource('/produto',ProdutoController::class);

    Route::get('/vendas/{id}/pdf', [VendaController::class, 'gerarPdf'])->name('vendas.pdf');

  
});