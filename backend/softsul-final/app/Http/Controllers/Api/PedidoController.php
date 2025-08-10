<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    public function index()
    {
        try {
            return PedidoResource::collection(Pedido::orderBy('id', 'desc')->get());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome_cliente' => 'required|string|max:255',
                'data_pedido' => 'required|date',
                'data_entrega' => 'nullable|date|after_or_equal:data_pedido',
                'status' => 'sometimes|in:pendente,entregue,cancelado',
            ]);
            $pedido = Pedido::create($validatedData);
            return (new PedidoResource($pedido))->response()->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Pedido $pedido)
    {
        return new PedidoResource($pedido);
    }

    public function update(Request $request, Pedido $pedido)
    {
        try {
            $validatedData = $request->validate([
                'nome_cliente' => 'required|string|max:255',
                'data_pedido' => 'required|date',
                'data_entrega' => 'nullable|date|after_or_equal:data_pedido',
                'status' => 'required|in:pendente,entregue,cancelado',
            ]);
            $pedido->update($validatedData);
            return new PedidoResource($pedido);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Pedido $pedido)
    {
        try {
            $pedido->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}