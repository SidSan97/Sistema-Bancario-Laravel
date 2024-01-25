<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroClienteModel;
use App\Models\DadosBancarioModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CadastroClienteController extends Controller
{
    public function cadastro(Request $request)
    {
        DB::beginTransaction();

        try {
            $cadastro = new CadastroClienteModel;

            $cadastro->nome         = $request->nome;
            $cadastro->email        = $request->email;
            $cadastro->rg           = $request->rg;
            $cadastro->cpf          = $request->cpf_cnpj;
            $cadastro->data_nascimento = $request->data_nascimento;
            $cadastro->telefone     = $request->telefone;
            $cadastro->estado_civil = $request->estado_civil;
            $cadastro->sexo         = $request->sexo;
            $cadastro->cep          = $request->cep;
            $cadastro->estado       = $request->estado;
            $cadastro->cidade       = $request->cidade;
            $cadastro->bairro       = $request->bairro;
            $cadastro->rua          = $request->rua;
            $cadastro->complemento  = $request->complemento;

            if ($cadastro->save()) {

                $id = $cadastro->getKey();

                $dados = $this->dadosBancario($id);

                if ($dados) {

                    $user = $this->user($id, $request->nome, $request->email ,$request->senha);

                    if($user) {
                        DB::commit();

                        return response()->json([
                            "status"  => 201,
                            "message" => "Cadastro feito com sucesso"
                        ], 201);
                    }
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
                "message" => "Erro interno do servidor: " . $e->getMessage()
            ], 500);
        }
    }

    public function dadosBancario($id) {

        $dados = new DadosBancarioModel;

        $dados->id_cadastro = $id;
        $dados->agencia = 1162;
        $dados->numero_conta = mt_rand(100000, 999999);
        $dados->saldo = 0;

        if(!$dados->save()) {
            return false;
        }

        return true;
    }

    public function user($id, $nome ,$email, $senha) {

        $user = new User();

        $user->id_cadastro = $id;
        $user->name = $nome;
        $user->email = $email;
        $user->password = $senha;

        if(!$user->save())
            return false;

        return true;
    }
}
