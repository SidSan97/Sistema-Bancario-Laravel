<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroClienteModel;
use App\Models\LoginModel;

class CadastroClienteController extends Controller
{
    public function cadastro(Request $request)
    {
        $user = new CadastroClienteModel;

        $user->nome         = $request->nome;
        $user->email        = $request->email;
        $user->senha        = $request->senha;
        $user->rg           = $request->rg;
        $user->cpf          = $request->cpf_cnpj;
        $user->data_nascimento = $request->data_nascimento;
        $user->telefone     = $request->telefone;
        $user->estado_civil = $request->estado_civil;
        $user->sexo         = $request->sexo;
        $user->cep          = $request->cep;
        $user->estado       = $request->estado;
        $user->cidade       = $request->cidade;
        $user->bairro       = $request->bairro;
        $user->rua          = $request->rua;
        $user->complemento  = $request->complemento;
        $user->saldo = 0;

        if($user->save()) {

            $id = $user->getKey();

            $dados = $this->login($id, $user->nome, $user->email,  $user->senha);

            if($dados === true) {

                return response()->json([
                    "status"  => 201,
                    "message" => "Cadastro feito com sucesso"
                ], 201);

            } else {

                return response()->json([
                    "status"  => 401,
                    "message" => "Erro ao efetuar cadastro"
                ], 401);
            }

        } else {

            return response()->json([
                "status"  => 401,
                "message" => "Erro ao efetuar cadastro"
            ], 401);
        }
    }

    public function login($id, $email, $senha) {

        $user = new LoginModel;

        $user->id_cliente = $id;
        $user->email = $email;
        $user->senha = $senha;

        if($user->save()) {

            return true;

        } else {

            return false;
        }
    }
}
