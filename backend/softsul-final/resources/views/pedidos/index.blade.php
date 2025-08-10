@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Pedidos</h1>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Adicionar Pedido</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Cliente</th>
                        <th>Data do Pedido</th>
                        <th>Data da Entrega</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->nome_cliente }}</td>
                            <td>{{ $pedido->data_pedido->format('d/m/Y') }}</td>
                            <td>{{ $pedido->data_entrega ? $pedido->data_entrega->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($pedido->status == 'pendente') bg-warning 
                                    @elseif($pedido->status == 'entregue') bg-success 
                                    @else bg-danger @endif">
                                    {{ ucfirst($pedido->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pedidos->hasPages())
        <div class="card-footer">
            {{ $pedidos->links() }}
        </div>
        @endif
    </div>
@endsection