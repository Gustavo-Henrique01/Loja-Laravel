@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    @if($produto->imagem)
                        <img src="{{ asset('storage/' . $produto->imagem) }}" class="card-img-top" alt="{{ $produto->nome }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Imagem Padrão">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->nome }}</h5>
                        <p class="card-text">{{ $produto->descricao }}</p>
                        <p class="card-text"><strong>Valor:</strong> R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                        <p class="card-text"><strong>Quantidade Disponível:</strong> {{ $produto->quantidade }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('editar-produto', $produto->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('deletar-produto', $produto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este produto?')">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
