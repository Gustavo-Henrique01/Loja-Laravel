<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
  
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('scripts')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{route('view-formProduto')}}">Cadastrar Produto</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('listar-produto')}}">Produtos</a></li>
        
                    @else
                        
                    <li class="nav-item"><a class="nav-link" href="{{ route('Produtos-a-Venda')}}">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('view-form')}}">Cadastrar   Perfil</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listagem-Pedido')}}">
                            <img src="{{ asset('/storage/imagens/sacolas-de-compras.png') }}" 
                                style="width: 5vh; height: 5vh;" 
                                alt="Carrinho de Compras">
                        </a>

                    </li>


                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('sair-login') }}">Sair</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
