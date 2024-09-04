@extends('layouts.app')

@section('content')
<div class="container rounded bg-info mt-5 w-40">
    <form action="{{ route('salvar-cliente') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 border-right d-flex justify-content-center align-items-center mt-5">
                <div class="personal-image">
                    <label class="label">
                        <input type="file" name="foto" id="foto"/>
                        <figure class="personal-figure">
                            @if(isset($cliente) && $cliente->foto)
                                <img src="{{ asset('storage/' . $cliente->foto) }}" class="personal-avatar" alt="avatar">
                            @else
                                <img src="{{ asset('storage/imagens/2.png') }}" class="personal-avatar" alt="avatar">
                            @endif
                            <figcaption class="personal-figcaption">
                                <img src="https://raw.githubusercontent.com/ThiagoLuizNunes/angular-boilerplate/master/src/assets/imgs/camera-white.png" alt="Upload">
                            </figcaption>
                        </figure>
                    </label>
                    <!-- Exibindo mensagem de erro para o campo 'foto' -->
                    @error('foto')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-8">
                <div class="p-3 py-5">
                    <div class="row mt-2 align-items-center">
                        <div class="col-md-10">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" readonly>
                            <!-- Exibindo mensagem de erro para o campo 'name' -->
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-link p-0" onclick="toggleEdit('name')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 align-items-center">
                        <div class="col-md-10">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" readonly>
                            <!-- Exibindo mensagem de erro para o campo 'email' -->
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-link p-0" onclick="toggleEdit('email')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 align-items-center">
                        <div class="col-md-10">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf', $cliente->cpf ?? '') }}" readonly>
                            <!-- Exibindo mensagem de erro para o campo 'cpf' -->
                            @error('cpf')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-link p-0" onclick="toggleEdit('cpf')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 align-items-center">
                        <div class="col-md-10">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}" readonly>
                            <!-- Exibindo mensagem de erro para o campo 'telefone' -->
                            @error('telefone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-link p-0" onclick="toggleEdit('telefone')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 text-left">
                        <div class="col-md-6">
                            <button class="btn btn-primary profile-button" type="submit">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleEdit(fieldId) {
        var inputField = document.getElementById(fieldId);
        if (inputField) {
            if (inputField.hasAttribute('readonly')) {
                inputField.removeAttribute('readonly');
                inputField.focus(); // Foca no campo opcionalmente
            } else {
                inputField.setAttribute('readonly', 'readonly');
            }
        }
    }
</script>
@endpush

@endsection
