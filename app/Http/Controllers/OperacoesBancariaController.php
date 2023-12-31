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
        $usuario = DadosBancarioModel::findOrFail(1);
        $dados = $this->verificarDestinatario($request->num_conta_destinatario);

        if($dados->status == 204) {
            return $dados;
        }

        if($dados->saldo )
    }

    public function verificarDestinatario($numeroConta)
    {
        $dados = DadosBancarioModel::where('numero_conta', $numeroConta)->first();

        if ($dados == null) {
            return response()->json([
                "status"  => 204,
                "message" => "Nenhuma conta bancária foi encontrada"
            ], 204);
        }

        return $dados;
    }
}
