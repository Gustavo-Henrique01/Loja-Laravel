<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Middleware\AdminAcess;
use App\Http\Middleware\ClienteAcess;
use App\Models\Pedido;
use App\Models\PedidoProduto;

// Proteger as rotas de clientes com o middleware auth
Route::middleware(ClienteAcess::class)->prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('listagem-clientes');
    Route::get('/create', [ClienteController::class, 'create'])->name('view-form');
    Route::post('/save', [ClienteController::class, 'store'])->name('salvar-cliente'); 
    Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('editar-cliente'); 
    Route::put('/{id}', [ClienteController::class, 'update'])->name('atualizar-cliente'); 
    Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('deletar-cliente'); 
    Route::get('/Produtos', [ProdutoController::class, 'ProdutosVenda'])->name('Produtos-a-Venda'); 
    Route::get('/Pedidos', [PedidoController::class, 'listaPedidos'])->name('listagem-Pedido');
    Route::post('/createPedido', [PedidoController::class, 'PedidoCreate'])->name('pedido-create'); 
    Route::get('/Produtos', [ProdutoController::class, 'ProdutosVenda'])->name('Produtos-a-Venda'); 
   
    Route::delete('/delete-pedido-produto/{id}', [PedidoController::class, 'destroy'])->name('pedido-produto-destroy');
    // routes/web.php
 

    Route::post('/atualizar-quantidade', [PedidoController::class, 'atualizarQuantidade'])->name('atualizar-quantidade');


});


// Proteger as rotas de pedidos com o middleware auth


// Rotas relacionadas ao login e registro de usuários
Route::prefix('login')->group(function(){
    Route::post('/create', [LoginController::class, 'create'])->name('registrar-login'); 
    Route::post('/login', [LoginController::class, 'login'])->name('validar-login'); 
    Route::get('/logout', [LoginController::class, 'logout'])->name('sair-login'); 

});


Route::middleware(AdminAcess::class)->prefix('produto')->group(function () {
    Route::get('/', [ProdutoController::class, 'formProduto'])->name('view-formProduto'); 
    Route::post('/', [ProdutoController::class, 'store'])->name('cadastrar-produto'); 
    Route::get('/list', [ProdutoController::class, 'all'])->name('listar-produto'); 
    Route::get('/{id}/edit', [ProdutoController::class, 'edit'])->name('editar-produto'); 
    Route::delete('/{id}/delete', [ProdutoController::class, 'destroy'])->name('deletar-produto'); 
    Route::put('/atualizar/{id}', [ProdutoController::class, 'update'])->name('atualizar-produto'); 

});

Route::get('/',[LoginController::class,'showForm'])->name('login');

// Proteger a rota home com o middleware auth
Route::middleware('auth')->get('home', function () {
   return view('home');
})->name('home');