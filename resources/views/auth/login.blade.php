<!DOCTYPE html>
<html>
<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slide_navbar_style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/app.css">
    
</head>
<body>



@if(session('success'))
        <div class="alert alert-success" role="alert" >
            {{ session('success') }}
        </div>
    @endif
    <div class="main">
	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="POST" action=" {{ route('registrar-login')}}">
                @csrf
                <label for="chk" aria-hidden="true">Registre</label>
                <input type="text" name="name" placeholder="Nome" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Senha" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar Senha" required>
                <!-- Adicionando um campo de seleção para a role -->
                <select name="role" required>
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>

                <button type="submit">Registrar</button>
            </form>
        </div>

        <div class="login">
            <form method="POST" action="{{route('validar-login')}}">
                @csrf
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Senha" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>