<?php

namespace App\Http\Controllers;

use App\Models\DadosBancarioModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function logar(Request $request)
    {
        $email = $request->email;
        $senha = $request->senha;

        $credencial = DadosBancarioModel::join('dados_cadastro_cliente', 'dados_bancarios.id_cliente', '=', 'dados_cadastro_cliente.id_cadastro')
        ->where('dados_bancarios.email', $email)
        ->first();

        if($credencial == null) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        if(password_verify($senha, $credencial->senha)) {
            $dados = [
                "logado" => true,
                "id"     => $credencial->id_cliente,
                "nome"   => $credencial->nome
            ];

            $request->session()->put($dados);

        } else {

            return response()->json([
                "status"  => 400,
                "message" => "Credenciais inválidas."
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        return $request->session()->all();
    }
}
