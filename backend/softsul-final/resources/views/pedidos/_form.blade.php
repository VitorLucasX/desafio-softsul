<div class="mb-3">
    <label for="nome_cliente" class="form-label">Nome do Cliente</label>
    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="{{ old('nome_cliente', $pedido->nome_cliente ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="data_pedido" class="form-label">Data do Pedido</label>
    <input type="date" class="form-control" id="data_pedido" name="data_pedido" value="{{ old('data_pedido', isset($pedido) ? $pedido->data_pedido->format('Y-m-d') : date('Y-m-d')) }}" required>
</div>
<div class="mb-3">
    <label for="data_entrega" class="form-label">Data da Entrega</label>
    <input type="date" class="form-control" id="data_entrega" name="data_entrega" value="{{ old('data_entrega', isset($pedido->data_entrega) ? $pedido->data_entrega->format('Y-m-d') : '') }}">
</div>
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" id="status" name="status" required>
        <option value="pendente" @selected(old('status', $pedido->status ?? '') == 'pendente')>Pendente</option>
        <option value="entregue" @selected(old('status', $pedido->status ?? '') == 'entregue')>Entregue</option>
        <option value="cancelado" @selected(old('status', $pedido->status ?? '') == 'cancelado')>Cancelado</option>
    </select>
</div>
<button type="submit" class="btn btn-primary">Salvar</button>
<a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>