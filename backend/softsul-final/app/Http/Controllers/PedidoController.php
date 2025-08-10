<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderBy('id', 'desc')->paginate(10);
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'data_pedido' => 'required|date',
            'data_entrega' => 'nullable|date|after_or_equal:data_pedido',
            'status' => 'required|in:pendente,entregue,cancelado',
        ]);
        Pedido::create($validatedData);
        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso.');
    }

    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validatedData = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'data_pedido' => 'required|date',
            'data_entrega' => 'nullable|date|after_or_equal:data_pedido',
            'status' => 'required|in:pendente,entregue,cancelado',
        ]);
        $pedido->update($validatedData);
        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso.');
    }
}