<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index() 
    {
        $userId = Auth::id();
        $clientes = Cliente::where('user_id', $userId)->get();
        return view('listagemClientes', compact('clientes'));
    }

    public function create(Request $request)
    {
        $userId = Auth::id();
        $cliente = Cliente::where('user_id', $userId)->first();
        $user = User::findOrFail($userId);
        return view('registrations.cadastroCliente', compact('user', 'cliente'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $cliente = Cliente::where('user_id', $userId)->first();

        $rules= [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users,email,' . $userId,
            'cpf' => 'nullable|string|max:11|unique:clientes,cpf,' . ($cliente->id ?? ''),
            'telefone' => 'nullable|string|max:11',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
        $messages = [
            'name.required'=> 'O Nome não pode estar vazio',
            'name.max' => 'exedeu o limite de  50 caracteres',
            'email.max' => 'exedeu o limite de  50 caracteres',
            'email.unique' => 'Já existe um usuario cadastrado com esse Endereço Email',
            'cpf.unique' => 'Já existe um usuario cadastrado com esse CPF. Insira um novo CPF.',
            'telefone.max' => 'Insira um numero de telefone valido',
           'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.mimes' => 'O arquivo de imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'foto.max' => 'A imagem não pode ser maior que 2MB.',
            
        ];
        $request->validate($rules, $messages);
       
             $user = User::find($userId);
         
         
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            
        // Manipulação do cliente
        if ($cliente) {
            $cliente->nome = $user->name;
            $cliente->cpf = $request->input('cpf');
            $cliente->telefone = $request->input('telefone');

            if ($request->hasFile('foto')) {
                if ($cliente->foto && Storage::disk('public')->exists($cliente->foto)) {
                    Storage::disk('public')->delete($cliente->foto);
                }
                $fotoPath = $request->file('foto')->store('imagens', 'public');
                $cliente->foto = $fotoPath;
            }

            $cliente->save();
            $message = 'Usuário atualizado com sucesso.';
        } else {
            $cliente = new Cliente();
            $cliente->user_id = $userId;
            $cliente->nome = $user->name;
            $cliente->cpf = $request->input('cpf');
            $cliente->telefone = $request->input('telefone');

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('imagens', 'public');
                $cliente->foto = $fotoPath;
            }

            $cliente->save();
            $message = 'Usuário cadastrado com sucesso.';
        }

        return redirect()->route('home')->with('success', $message);
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cadastroCliente', compact('cliente'));
    }

   
}
