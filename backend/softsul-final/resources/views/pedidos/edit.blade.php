@extends('layouts.app')

@section('content')
    <h1>Editar Pedido #{{ $pedido->id }}</h1>
    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('pedidos._form')
    </form>
@endsection