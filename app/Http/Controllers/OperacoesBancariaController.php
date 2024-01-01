<?php

namespace App\Http\Controllers;

use App\Models\DadosBancarioModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OperacoesBancariaController extends Controller
{
    public function depositar(Request $request)
    {
        $numeroConta = $request->num_conta;

        $dados = DadosBancarioModel::where('numero_conta', $numeroConta)->first();

        if ($dados == null) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        $dados->saldo += $request->valor_deposito;

        $dados->save();

        return response()->json([
            "status"  => 200,
            "message" => "Depósito feito com sucesso"
        ], 200);
    }

    public function transferencia(Request $request)
    {
        DB::beginTransaction();

        $usuario = DadosBancarioModel::findOrFail(1);
        $dados = $this->verificarDestinatario($request->num_conta_destinatario);

        if($dados == false) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        if(($usuario->saldo) < ($request->valor_transferencia)) {
            return response()->json([
                "status"  => 400,
                "message" => "Saldo insuficiente."
            ], 400);
        }

        $usuario->saldo -= $request->valor_transferencia;
        $dados->saldo += $request->valor_transferencia;

        if(!$usuario->save() || !$dados->save()) {
            DB::rollBack();

            return response()->json([
                "status"  => 500,
                "message" => "Erro ao fazer transferência, tente novamente."
            ], 500);
        }

        DB::commit();
        return response()->json([
            "status"  => 200,
            "message" => "Transação efetuada com sucesso."
        ], 200);
    }

    public function verificarDestinatario($numeroConta)
    {
        $dados = DadosBancarioModel::where('numero_conta', $numeroConta)->first();

        if ($dados == null) {
            return false;
        }

        return $dados;
    }
}
