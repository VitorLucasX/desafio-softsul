import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/pedido_model.dart';

class ApiService {
  static const String _baseUrl = 'http://10.0.2.2:8080/api';
  static const Map<String, String> _headers = {
    'Content-Type': 'application/json; charset=UTF-8',
    'Accept': 'application/json',
  };

  // Buscar todos os pedidos (READ)
   static Future<List<Pedido>> getPedidos() async {
    final response = await http.get(Uri.parse('$_baseUrl/pedidos'));
    if (response.statusCode == 200) {
      final Map<String, dynamic> body = json.decode(response.body);
      final List<dynamic> data = body['data'];
      return data.map((json) => Pedido.fromJson(json)).toList();
    } else {
      throw Exception('Falha ao carregar pedidos');
    }
  }

  // Criar um novo pedido (CREATE)
  static Future<Pedido> createPedido(Pedido pedido) async {
    final response = await http.post(
      Uri.parse('$_baseUrl/pedidos'),
      headers: _headers,
      body: json.encode(pedido.toJson()),
    );
    if (response.statusCode == 201) {
      return Pedido.fromJson(json.decode(response.body)['data']);
    } else {
      throw Exception('Falha ao criar pedido');
    }
  }

  // Atualizar um pedido (UPDATE)
  static Future<Pedido> updatePedido(int id, Pedido pedido) async {
    final response = await http.put(
      Uri.parse('$_baseUrl/pedidos/$id'),
      headers: _headers,
      body: json.encode(pedido.toJson()),
    );
    if (response.statusCode == 200) {
      return Pedido.fromJson(json.decode(response.body)['data']);
    } else {
      throw Exception('Falha ao atualizar pedido');
    }
  }

  // Apagar um pedido (DELETE)
  static Future<void> deletePedido(int id) async {
    final response = await http.delete(Uri.parse('$_baseUrl/pedidos/$id'));
    if (response.statusCode != 204) {
      throw Exception('Falha ao apagar pedido');
    }
  }
}