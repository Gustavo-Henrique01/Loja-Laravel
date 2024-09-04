@extends('layouts.app')

@section('content')
<div class="container">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <h1 class="text-light">{{ isset($pedido) ? 'Editar Pedido' : 'Cadastrar Novo Pedido' }}</h1>
    <form action="{{ isset($pedido) ? route('atualizar-pedido', $pedido->id) : route('salvar-pedido') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($pedido))
        @method('PUT')
    @endif
    <!-- Campos do formulário -->
    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select class="form-select" id="cliente_id" name="cliente_id" required>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ (isset($pedido) && $pedido->cliente_id == $cliente->id) ? 'selected' : '' }}>
                    {{ $cliente->nome }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $pedido->descricao ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="valor" class="form-label">Valor</label>
        <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $pedido->valor ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="imagem" class="form-label">Imagem</label>
        <input type="file" class="form-control" id="imagem" name="imagem">
        @if(isset($pedido) && $pedido->imagem)
            <img src="{{ asset('storage/' . $pedido->imagem) }}" alt="Imagem do Pedido" style="width: 100px; height: auto;">
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ isset($pedido) ? 'Atualizar' : 'Salvar' }}</button>
</form>
@endsection
