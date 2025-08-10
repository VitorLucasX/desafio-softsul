<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PedidoController;

Route::apiResource('pedidos', PedidoController::class);
