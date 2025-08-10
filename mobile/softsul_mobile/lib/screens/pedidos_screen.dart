import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../models/pedido_model.dart';
import '../services/api_service.dart';

class PedidosScreen extends StatefulWidget {
  const PedidosScreen({super.key});

  @override
  State<PedidosScreen> createState() => _PedidosScreenState();
}

class _PedidosScreenState extends State<PedidosScreen> {
  late Future<List<Pedido>> _pedidosFuture;

  @override
  void initState() {
    super.initState();
    _refreshPedidos();
  }

  void _refreshPedidos() {
    setState(() {
      _pedidosFuture = ApiService.getPedidos();
    });
  }

  void _showFormDialog({Pedido? pedido}) {
    final formKey = GlobalKey<FormState>();
    final nomeController = TextEditingController(text: pedido?.nomeCliente);
    final dataPedidoController = TextEditingController(
        text: pedido?.dataPedido ??
            DateFormat('yyyy-MM-dd').format(DateTime.now()));
    final dataEntregaController = TextEditingController(text: pedido?.dataEntrega);
    String status = pedido?.status ?? 'pendente';

    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: Text(pedido == null ? 'Adicionar Pedido' : 'Editar Pedido'),
          content: SingleChildScrollView(
            child: Form(
              key: formKey,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  TextFormField(
                    controller: nomeController,
                    decoration:
                        const InputDecoration(labelText: 'Nome do Cliente'),
                    validator: (value) =>
                        value!.isEmpty ? 'Campo obrigatório' : null,
                  ),
                  TextFormField(
                    controller: dataPedidoController,
                    decoration: const InputDecoration(
                        labelText: 'Data do Pedido (AAAA-MM-DD)'),
                    validator: (value) =>
                        value!.isEmpty ? 'Campo obrigatório' : null,
                  ),
                  TextFormField(
                    controller: dataEntregaController,
                    decoration: const InputDecoration(
                        labelText: 'Data da Entrega (AAAA-MM-DD)'),
                  ),
                  DropdownButtonFormField<String>(
                    value: status,
                    decoration: const InputDecoration(labelText: 'Status'),
                    items: ['pendente', 'entregue', 'cancelado']
                        .map((s) => DropdownMenuItem(value: s, child: Text(s)))
                        .toList(),
                    onChanged: (value) => status = value!,
                  ),
                ],
              ),
            ),
          ),
          actions: [
            TextButton(
                onPressed: () => Navigator.pop(context),
                child: const Text('Cancelar')),
            ElevatedButton(
              onPressed: () async {
                if (formKey.currentState!.validate()) {
                  final novoPedido = Pedido(
                    id: pedido?.id,
                    nomeCliente: nomeController.text,
                    dataPedido: dataPedidoController.text,
                    dataEntrega: dataEntregaController.text.isNotEmpty
                        ? dataEntregaController.text
                        : null,
                    status: status,
                  );

                  try {
                    if (pedido == null) {
                      await ApiService.createPedido(novoPedido);
                    } else {
                      await ApiService.updatePedido(pedido.id!, novoPedido);
                    }
                    Navigator.pop(context);
                    _refreshPedidos();
                  } catch (e) {
                    ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(content: Text('Erro ao salvar: $e')));
                  }
                }
              },
              child: const Text('Salvar'),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Softsul Pedidos'),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: _refreshPedidos,
          ),
        ],
      ),
      body: FutureBuilder<List<Pedido>>(
        future: _pedidosFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }
          if (snapshot.hasError) {
            return Center(child: Text('Erro: ${snapshot.error}'));
          }
          if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('Nenhum pedido encontrado.'));
          }

          final pedidos = snapshot.data!;
          return ListView.builder(
            itemCount: pedidos.length,
            itemBuilder: (context, index) {
              final pedido = pedidos[index];
              return Card(
                margin: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                child: ListTile(
                  title: Text(pedido.nomeCliente),
                  subtitle: Text(
                      'Pedido: ${pedido.dataPedido} - Status: ${pedido.status}'),
                  trailing: Row(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      IconButton(
                        icon: const Icon(Icons.edit, color: Colors.orange),
                        onPressed: () => _showFormDialog(pedido: pedido),
                      ),
                      IconButton(
                        icon: const Icon(Icons.delete, color: Colors.red),
                        onPressed: () async {
                          try {
                            await ApiService.deletePedido(pedido.id!);
                            _refreshPedidos();
                          } catch (e) {
                            ScaffoldMessenger.of(context).showSnackBar(
                                SnackBar(content: Text('Erro ao apagar: $e')));
                          }
                        },
                      ),
                    ],
                  ),
                ),
              );
            },
          );
        },
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => _showFormDialog(),
        child: const Icon(Icons.add),
      ),
    );
  }
}