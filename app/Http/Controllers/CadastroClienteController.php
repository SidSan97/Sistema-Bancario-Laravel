<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroClienteModel;
use App\Models\DadosBancarioModel;
use Illuminate\Support\Facades\DB;

class CadastroClienteController extends Controller
{
    public function cadastro(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = new CadastroClienteModel;

            $user->nome         = $request->nome;
            $user->email        = $request->email;
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

            if ($user->save()) {

                $id = $user->getKey();

                $dados = $this->dadosBancario($id, $user->email, $request->senha);

                if ($dados === true) {
                    DB::commit();

                    return response()->json([
                        "status"  => 201,
                        "message" => "Cadastro feito com sucesso"
                    ], 201);

                } else {

                    DB::rollBack();

                    return response()->json([
                        "status"  => 401,
                        "message" => "Erro ao efetuar cadastro"
                    ], 401);
                }

            } else {

                DB::rollBack();

                return response()->json([
                    "status"  => 401,
                    "message" => "Erro ao efetuar cadastro"
                ], 401);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "status"  => 500,
                "message" => "Erro interno do servidor"
            ], 500);
        }
    }

    public function dadosBancario($id, $email, $senha) {

        $user = new DadosBancarioModel;

        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $user->id_cliente = $id;
        $user->email = $email;
        $user->senha = $senha;
        $user->agencia = 1162;
        $user->numero_conta = mt_rand(100000, 999999);
        $user->saldo = 0;

        if(!$user->save()) {
            return false;
        }

        return true;
    }
}
