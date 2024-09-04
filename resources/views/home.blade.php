@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
        @if(Auth::check() && Auth::user()->role === 'admin') 
            <h1 class=" text-balck ">Bem-vindo ao Sistema de Gerenciamento</h1>
        @else 
        <h1 class=" text-black ">Bem-vindo a Loja </h1>
        @endif
          
        
        </div>
    </div>
</div>
@endsection
