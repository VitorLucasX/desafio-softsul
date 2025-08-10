class Pedido {
  final int? id;
  final String nomeCliente;
  final String dataPedido;
  final String? dataEntrega;
  final String status;

  Pedido({
    this.id,
    required this.nomeCliente,
    required this.dataPedido,
    this.dataEntrega,
    required this.status,
  });

  factory Pedido.fromJson(Map<String, dynamic> json) {
    return Pedido(
      id: json['id'],
      nomeCliente: json['nome_cliente'],
      dataPedido: json['data_pedido'],
      dataEntrega: json['data_entrega'],
      status: json['status'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'nome_cliente': nomeCliente,
      'data_pedido': dataPedido,
      'data_entrega': dataEntrega,
      'status': status,
    };
  }
}