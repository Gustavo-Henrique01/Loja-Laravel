@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Produtos Disponíveis</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="{{ Storage::url($produto->imagem) }}" class="card-img-top" alt="{{ $produto->nome }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->nome }}</h5>
                        <p class="card-text">{{ $produto->descricao }}</p>
                        <p class="card-text">Preço: R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                        <p class="card-text">Quantidade Disponível: {{ $produto->quantidade }}</p>
                        
                        <form action="{{route('pedido-create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="quantidade_{{ $produto->id }}">Quantidade</label>
                                <input type="number" name="quantidade" id="quantidade_{{ $produto->id }}" class="form-control" 
                                    min="1" max="{{ $produto->quantidade }}" value="1" required>
                            </div>
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                            <button type="submit" class="btn btn-primary mt-2">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
