@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class=" text-light ">Listagem de Clientes</h1>
    <a href="{{ route('cadastro-cliente') }}" class="btn btn-primary mb-3">Cadastrar Novo Cliente</a>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Idade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->data_nascimento->format('d/m/Y') }}</td>
                    <td>{{ $cliente->idade }}</td>
                    <td>
                        <a href="{{ route('editar-cliente', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('deletar-cliente', $cliente->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Você tem certeza que deseja excluir este cliente?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum cliente encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
