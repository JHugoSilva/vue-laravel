<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioAtualizarRequest;
use App\Http\Requests\UsuarioCadastrarRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request){
        $param = $request->search;

        $usuarios = UsuarioResource::collection(Usuario::where('status', 'ativo')->where(function($query) use($param) {
            if (!empty($param)) {
                $query->where('cpf', 'LIKE', '%'.$param.'%')
                    ->orWhere('nome', 'LIKE', '%'.$param.'%')
                    ->orWhere('email', 'LIKE', '%'.$param.'%');
            }
        })->latest()->paginate(2))->resource;

        if (!$usuarios) {
            return response()->json([
                'msg' => 'Usuários não foram encontrados!',
            ], 404);
        }

        return response()->json(['usuarios' => $usuarios], 200);
    }

    public function store(UsuarioCadastrarRequest $request){

        Usuario::create($request->getData());

        return response()->json([
            'msg' => 'Usuário criado com sucesso!',
        ], 201);
    }

    public function update(UsuarioAtualizarRequest $request, $id){

        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'msg' => 'Usuário não foi encontrado!',
            ], 404);
        }

        $usuario->update($request->getData());

        return response()->json([
            'msg' => 'Usuário atualizado com sucesso!',
        ], 200);
    }

    public function show($id){

        $usuario = new UsuarioResource(Usuario::where('id', $id)->where('status', 'ativo')->first());

        if (!$usuario) {
            return response()->json([
                'msg' => 'Usuário não foi encontrado!',
            ], 404);
        }

        return response()->json([
            'usuario' => $usuario
        ], 200);
    }

    public function destroy($id){

        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'msg' => 'Usuário não foi encontrado!',
            ], 404);
        }

        $usuario->update([
            'status' => 'inativo'
        ]);

        return response()->json([
            'msg' => 'Usuário apagado com sucesso!'
        ], 200);

    }
}
