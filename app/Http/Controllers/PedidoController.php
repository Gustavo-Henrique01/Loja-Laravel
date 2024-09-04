<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\PedidoProduto;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PedidoController extends Controller
{
   
    public function listaPedidos ()
    {
        // Recupera o ID do usuário logado
        $userId = Auth::id();

        // Busca os pedidos relacionados ao usuário logado, com os produtos
        $pedidos = Pedido::where('user_id', $userId)
            ->with('produtos') // Eager loading para otimizar a consulta
            ->get();
       
            return view('listings.listagemPedido', compact('pedidos'));

        
        // Retorna a view com os pedidos
       
    }
   
    


    public function PedidoCreate(Request $request)
    {
        // Obtenha o ID do usuário autenticado
        $userId = Auth::id();
        
        // Verifique se o cliente existe para o usuário logado
        $cliente = Cliente::where('user_id', $userId)->first();
    
        if (!$cliente) {
            return redirect()->back()->with('error', 'Cliente não encontrado.');
        }
    
        // Verifique se já existe um pedido para este cliente que ainda não foi finalizado
        $pedido = Pedido::where('cliente_id', $cliente->id)->first();
         // Supondo que você tenha um campo 'finalizado' para indicar se o pedido foi concluído 
        // Se não existir um pedido, crie um novo
        if (!$pedido) {
            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'user_id' => $userId,
            ]);
        }
    
        // Agora adicione o produto ao pedido existente ou recém-criado
        PedidoProduto::create([
            'pedido_id' => $pedido->id,
            'produto_id' => $request->input('produto_id'),
            'quantidade' => $request->input('quantidade'),
        ]);
    
        return redirect()->back()->with('success', 'Produto adicionado ao pedido.');
    }


    
    public function edit($id){
    
     $pedido = Pedido::with('cliente')->findOrFail($id);
   
    $clientes = Cliente::all();

        return view('cadastroPedidos', compact('pedido','clientes'));
    }

 

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'O arquivo de imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'imagem.max' => 'A imagem não pode ser maior que 2MB.',
        ]);
    
        // Encontrar o pedido
        $pedido = Pedido::findOrFail($id);
    
        // Processar upload de imagem se existir
        if ($request->hasFile('imagem')) {
            // Deletar a imagem antiga se existir
            if ($pedido->imagem && file_exists(storage_path('app/public/' . $pedido->imagem))) {
                unlink(storage_path('app/public/' . $pedido->imagem));
            }
    
            // Armazenar a nova imagem no diretório 'public/imagens'
            $imagemPath = $request->file('imagem')->store('imagens', 'public');
            $pedido->imagem = $imagemPath;
        }
    
        // Atualizar os dados do pedido
        $pedido->cliente_id = $request->input('cliente_id');
        $pedido->descricao = $request->input('descricao');
        $pedido->valor = $request->input('valor');
        
        $pedido->update();
    
        return redirect()->route('listagem-pedidos')->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy( $id)
    {
        $pedido_produto = PedidoProduto::findOrFail($id);
        if( $pedido_produto){
        $pedido_produto->delete();}
        return redirect()->route('listagem-Pedido')->with('success', 'Pedido excluído com sucesso.');
    }


    public function atualizarQuantidade(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produtoPedido = PedidoProduto::find($request->input('id'));

        if ($produtoPedido) {
            $produtoPedido->quantidade = $request->input('quantidade');
            $produtoPedido->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}

    



