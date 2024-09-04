<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdutoController extends Controller
{


        public function formProduto ( ){

            return view( 'registrations.cadastroProduto');

        }
        public function store(Request $request)
        {
            // Validação dos dados
            $request->validate([
                'nome'=> 'required|string|max:50',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric',
                'quantidade' => 'required|numeric',
                'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);
        
            // Processar upload de imagem
            if ($request->hasFile('imagem')) {
                $imagemPath = $request->file('imagem')->store( 'imagens','public');
            }
            $user= Auth::user()->id;
         
            Produto::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'quantidade' => $request->quantidade,
                'imagem' => $imagemPath ?? null,
                'user_id' => $user,
            ]);
        
            return redirect()->route('view-formProduto')->with('success', 'Produto cadastrado com sucesso.');
        }


        public function all (){
            $user= Auth::user()->id;
            $produtos = Produto::where('user_id', $user)->orderby('id')->get();
            return view('listings.listagemProduto',compact('produtos'));

        }

        public function edit($id)
        {
            $produto = Produto::findOrFail($id);
            return view('registrations.cadastroProduto',compact('produto'));
        }
        
        public function update(Request $request, $id)
        {
            $request->validate([
                'nome' => 'required|string|max:50',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric',
                'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'quantidade' => 'required|numeric',
            ], [
                'imagem.image' => 'O arquivo deve ser uma imagem.',
                'imagem.mimes' => 'O arquivo de imagem deve ser do tipo: jpeg, png, jpg, gif,webp.',
                'imagem.max' => 'A imagem não pode ser maior que 2MB.',
            ]);
        
            $produto = Produto::findOrFail($id);
        
            // Processar upload de imagem se existir
            if ($request->hasFile('imagem')) {
                // Deletar a imagem antiga se existir
                if ($produto->imagem && file_exists(storage_path('app/public/' . $produto->imagem))) {
                    unlink(storage_path('app/public/' . $produto->imagem));
                }
        
                // Armazenar a nova imagem no diretório 'public/imagens'
                $imagemPath = $request->file('imagem')->store('imagens', 'public');
                $produto->imagem = $imagemPath;
            }
        
            // Atualizar os dados do produto
            $produto->nome = $request->input('nome');
            $produto->descricao = $request->input('descricao');
            $produto->valor = $request->input('valor');
            $produto->quantidade = $request->input('quantidade');
        
            // Salvar as alterações no banco de dados
            $produto->save();
        
            return redirect()->route('listar-produto')->with('success', 'Produto atualizado com sucesso!');
        }
        

        public function destroy ( $id ){

            try {
              $produto = Produto::findOrFail($id);
              $produto->delete();
              return redirect()->route('listar-produto')->with('sucess', 'Produto deletado com sucesso!.');

                
            } catch (ModelNotFoundException $e) {
                
                return redirect()->route('listar-produto')->with('error', 'Produto não encontrado.'.$e);
            }

        }


        public function ProdutosVenda (){


            $produtos = Produto::all();

            return view('listings.listagemProdutoVenda' ,compact('produtos'));
        }
    }