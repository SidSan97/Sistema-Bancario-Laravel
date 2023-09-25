<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CadastroCliente extends Controller
{
    public function cadastro(Request $request)
    {
        $user = new User();

        $user->nome     = $request->nome;
        $user->email    = $request->email;
        $user->senha = $request->senha;
        $user->rg       = $request->rg;
        $user->cpf_cnpj = $request->cpf_cnpj;
        $user->data_nascimento = $request->data_nascimento;
        $user->telefone = $request->telefone;
        $user->estado_civil = $request->estado_civil;
        $user->sexo         = $request->sexo;
        $user->cep          = $request->cep;
        $user->estado       = $request->estado;
        $user->cidade       = $request->cidade;
        $user->cidade       = $request->bairro;
        $user->rua          = $request->rua;
        $user->complemento  = $request->complemento;

        if($user->save())
            dd('enviou');
        else
            dd('nao enviou');
    }
}
