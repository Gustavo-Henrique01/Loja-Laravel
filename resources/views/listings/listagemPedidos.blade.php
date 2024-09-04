@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-light">Listagem de Pedidos</h1>
    <a href="{{ route('cadastro-pedido') }}" class="btn btn-primary mb-3">Cadastrar Novo Pedido</a>
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @elseif(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Imagem</th> <!-- Nova coluna para a imagem -->
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->cliente->nome }}</td>
            <td>{{ $pedido->descricao }}</td>
            <td>{{ $pedido->valor }}</td>
            <td>
                @if($pedido->imagem) 
                <img src="{{ asset('storage/' . $pedido->imagem) }}" alt="Imagem do Pedido" style="width: 100px; height: auto;">
                @else
                    Sem Imagem
                @endif
            </td>
            <td>
                <a href="{{ route('editar-pedido', $pedido->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('deletar-pedido', $pedido->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
