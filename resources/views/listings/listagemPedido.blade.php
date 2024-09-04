@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1 class="mb-4">Meus Pedidos</h1>

    @if($pedidos->isEmpty())
        <p>Você não tem nenhum pedido.</p>
    @else
        <div id="pedidoForm">
            @foreach($pedidos as $pedido)
                <div class="card mb-4">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <h6>Produtos:</h6>
                        <ul class="list-group">
                            @foreach($pedido->produtos as $produto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input produto-checkbox" type="checkbox" name="produtos[]" value="{{ $produto->valor * $produto->pivot->quantidade }}" id="produto_{{ $produto->id }}">
                                        <label class="form-check-label" for="produto_{{ $produto->id }}">
                                            <img src="{{ Storage::url($produto->imagem) }}" alt="{{ $produto->nome }}" class="img-thumbnail" style="width: 100px;">
                                            <strong>{{ $produto->nome }}</strong><br>
                                            <small>{{ $produto->descricao }}</small><br>
                                            <span>Quantidade:</span>
                                            <div class="input-group quantidade-group">
                                                <button type="button" class="btn btn-outline-secondary decrement-btn">-</button>
                                                <input type="number" class="form-control quantidade-input" data-id="{{ $produto->pivot->id }}" value="{{ $produto->pivot->quantidade }}" min="1" max="{{ $produto->quantidade }}" readonly name="quantidade">
                                                <button type="button" class="btn btn-outline-secondary increment-btn">+</button>
                                            </div><br>
                                            <span>R$ {{ number_format($produto->valor, 2, ',', '.') }} cada</span>
                                        </label>
                                    </div>
                                    <span class="text-right subtotal" data-preco="{{ $produto->valor }}">Subtotal: R$ {{ number_format($produto->valor * $produto->pivot->quantidade, 2, ',', '.') }}</span>

                                    <!-- Formulário para deletar o item -->
                                    <form action="{{ route('pedido-produto-destroy', $produto->pivot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja deletar este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="text-right">Total Selecionado: R$ <span id="totalSelecionado">0,00</span></h5>
                    <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.produto-checkbox');
        const totalElement = document.getElementById('totalSelecionado');
        let total = 0;

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const valor = parseFloat(this.value);

                if (this.checked) {
                    total += valor;
                } else {
                    total -= valor;
                }
                totalElement.textContent = total.toFixed(2).replace('.', ',');
            });
        });

        document.querySelectorAll('.decrement-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.quantidade-group').querySelector('.quantidade-input');
                let quantidade = parseInt(input.value);
                if (quantidade > 1) {
                    quantidade--;
                    input.value = quantidade;
                    atualizarSubtotal(input);
                    atualizarTotalSelecionado();
                    enviarAtualizacao(input.getAttribute('data-id'), quantidade);
                }
            });
        });

        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.quantidade-group').querySelector('.quantidade-input');
                let quantidade = parseInt(input.value);
                const maxQuantidade = parseInt(input.getAttribute('max'));

                if (quantidade < maxQuantidade) {
                    quantidade++;
                    input.value = quantidade;
                    atualizarSubtotal(input);
                    atualizarTotalSelecionado();
                    enviarAtualizacao(input.getAttribute('data-id'), quantidade);
                }
            });
        });

        function atualizarSubtotal(input) {
            const subtotalElement = input.closest('li').querySelector('.subtotal');
            const preco = parseFloat(subtotalElement.dataset.preco);
            const quantidade = parseInt(input.value);
            subtotalElement.textContent = `Subtotal: R$ ${(preco * quantidade).toFixed(2).replace('.', ',')}`;
        }

        function atualizarTotalSelecionado() {
            total = Array.from(document.querySelectorAll('.produto-checkbox:checked')).reduce((acc, checkbox) => {
                return acc + parseFloat(checkbox.value);
            }, 0);
            totalElement.textContent = total.toFixed(2).replace('.', ',');
        }

        function enviarAtualizacao(id, quantidade) {
            fetch('{{ route("atualizar-quantidade") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: id,
                    quantidade: quantidade
                })
            }).then(response => response.json())
              .then(data => {
                  if (!data.success) {
                      alert('Erro ao atualizar a quantidade.');
                  }
              }).catch(error => console.error('Erro:', error));
        }
    });
</script>
@endsection
