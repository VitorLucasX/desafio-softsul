@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Pedido</h1>
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        @include('pedidos._form')
    </form>
@endsection