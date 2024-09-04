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

    <h1 class="text-black">{{ isset($produto) ? 'Editar Produto' : 'Cadastrar Novo Produto' }}</h1>
    <form action="{{ isset($produto) ? route('atualizar-produto', $produto->id) : route('cadastrar-produto')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($produto))
            @method('PUT')
        @endif
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $produto->nome ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao', $produto->descricao ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control" id="valor" name="valor" value="{{ old('valor', $produto->valor ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade Disponível</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ old('quantidade', $produto->quantidade ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem do Produto</label>
            <input type="file" class="form-control" id="imagem" name="imagem">
            @if(isset($produto) && $produto->imagem)
                <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem do Produto" style="width: 100px; height: auto;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($produto) ? 'Atualizar' : 'Salvar' }}</button>
    </form>
@endsection