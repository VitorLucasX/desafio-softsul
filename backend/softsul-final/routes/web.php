<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

Route::resource('pedidos', PedidoController::class);